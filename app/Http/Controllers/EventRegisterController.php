<?php

namespace App\Http\Controllers;

use App\Attendee;
use App\Event;
use App\Http\Requests\EventRegistrationPostRequest;
use App\Mail\RegistrationSuccessful;
use App\Payment;
use Exception;
use Hashids\Hashids;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;
use function array_has;
use function array_key_exists;
use function compact;
use function env;
use function is_null;
use function response;

class EventRegisterController extends Controller
{
    /**
     * @var false
     */
    private $presenter;

    /**
     * EventRegisterController constructor.
     * @param $presenter
     */
    public function __construct()
    {
        $this->presenter = false;
    }


    /**
     * Display Event registration page
     *
     * @param Event $event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Event $event)
    {
        $presenter = $this->presenter;

        return view('event.register', compact('event', 'presenter'));
    }


    /**
     * Display Event registration page for presenters
     *
     * @param Event $event
     * @param string $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showPresenter(Event $event, string $code)
    {
        $this->presenter = $presenter = $this->verifyPresenter($event->id, $code, env('HASH_ID_SALT'));

        return view('event.register', compact('event', 'presenter'));
    }


    /**
     * Verify the code the ensure that the presenters should be able to see the special registration
     * @param $id
     * @param $code
     * @param string $salt
     * @return bool
     */
    private function verifyPresenter($id, $code, $salt = '')
    {
        $hashId = new Hashids($salt, 8);
        $decoded = $hashId->decode($code);

        return !empty($decoded) && $decoded[ 0 ] == $id;
    }

    /**
     * Process an event registration.
     *
     * @param $request
     * @param Event $event
     * @return \Illuminate\Http\Response
     * //EventRegistrationPostRequest
     * @throws Exception
     */
    public function register(EventRegistrationPostRequest $request, Event $event)
    {
        $all = $request->validated();

        $description = (array_key_exists('description', $all))
            ? $all[ 'description' ] : 'Event Charge';

        $tokenId = $all[ 'token' ][ 'id' ];
        $total = $all[ 'total' ];
        $charge = null;

        $charge = $this->chargeStripeToken($tokenId, $total, $description);
        $paymentAndAttendees = null;

        if ( $charge instanceof Charge ) {
            // charge was successful, so now save all the registration info to the database
            $paymentAndAttendees = $this->saveRegistrationAndPayment($all, $charge, $event);
        } elseif ( is_null($charge) ) {
            throw new Exception('Nothing happened when attempting to charge the token');
            //
        } elseif ( !$charge ) {
            throw new Exception('The charge returned false while attempting to charge the token');
        } elseif ( $charge instanceof Card ) {
            return response($charge->getJsonBody(), $charge->getHttpStatus());
        } else {
            Mail::to('techsupport@pocacoop.com')->send(new RegistrationError([
                'all' => $all,
                'charge' => $charge,
                'requested' => $request->all(),
            ], 'if/ifelse/else to check the charge'));
            throw new Exception('There is a general problem processing the charge');
        }

        //todo log the payment to and the registration

        // send email
        if ( $paymentAndAttendees !== null ) {
            $attendees = $paymentAndAttendees[ 'attendees' ];
            $payment = $paymentAndAttendees[ 'payment' ];
            //trigger event to send email?
            Mail::to($all[ 'token' ][ 'email' ])->send(new RegistrationSuccessful($attendees, $payment, $event));

            $payment_id = $payment->id;
            $route = '/events/' . $event->slug . '/registered/' . $payment_id;

            return response([ 'redirect' => $route ], 201);
        }

        // else return them to the registration form with some error message

        return response($paymentAndAttendees, 400);

//    }
//    catch ( Exception $e ) {
//      echo $e->getMessage();
//      echo $e->getTraceAsString();

//      return abort(400, $e->getMessage());

//    }
    }

    /**
     * Charge the provided stripe token for a registration.
     * @param $tokenId
     * @param $total
     * @param $description
     * @return Exception|false|Charge|Card
     */
    private function chargeStripeToken($tokenId, $total, $description)
    {
        try {
            $charge = false;
//      var_dump($tokenId);die();
            if ( $tokenId != '' && $total > 0 ) {
                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                $token = $tokenId;
                $charge = Charge::create([
                    'amount' => $total,
                    'currency' => 'usd',
                    'description' => $description,
                    'source' => $token,
                ]);
            }

            return $charge;
        } catch ( \Stripe\Error\Card $e ) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err = $body[ 'error' ];
//      var_dump($body[ 'error' ]);
            //TODO: log all declines to a DB table, set up error logging
//      abort($e->getHttpStatus(), $err);
//      throw $e;
            return $e;
            echo 'Status is:' . $e->getHttpStatus() . "\n";
            echo 'Type is:' . $err[ 'type' ] . "\n";
            echo 'Code is:' . $err[ 'code' ] . "\n";
            // param is '' in this case
            echo 'Param is:' . $err[ 'param' ] . "\n";
            echo 'Message is:' . $err[ 'message' ] . "\n";
        } catch ( \Stripe\Error\RateLimit $e ) {
            //TODO: Need to handle all these errors?
            // Too many requests made to the API too quickly
        } catch ( \Stripe\Error\InvalidRequest $e ) {
            // Invalid parameters were supplied to Stripe's API
        } catch ( \Stripe\Error\Authentication $e ) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch ( \Stripe\Error\ApiConnection $e ) {
            // Network communication with Stripe failed
        } catch ( \Stripe\Error\Base $e ) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
        }
    }

    /**
     * Save the registration and payment information collected on the registration form
     * @param array $all
     * @param $charge
     * @param Event $event
     * @return array
     * @throws Exception
     */
    private function saveRegistrationAndPayment(array $all, $charge, Event $event)
    {
        try {
            DB::beginTransaction();
            $payment = $this->savePayment($all, $charge, $event); //App\Payment
            $attendees = [];
            foreach ( $all[ 'registrants' ] as $registrant ) {
                $attendees[] = $this->createRegistration($registrant, $event, $payment); // array of attendees with first being the payor
            }
            $payment->payer_id = $attendees[ 0 ]->id;
            $payment->save();
            DB::commit();

            return [ 'payment' => $payment, 'attendees' => $attendees ];
        } catch ( Exception $e ) {
            Mail::to('techsupport@pocacoop.com')->send(new RegistrationError([
                'all' => $all,
                'charge' => $charge,
                'event' => $event,
                'error' => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            ], 'saveRegistrationAndPayment catch'));
            //todo: I think that we're occasionally hitting this and it's not breaking the way it shoul break, add logging
            DB::rollBack();
            throw new Exception('There was a problem persisting the registration or payment: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Save the payment information collected in the registration form
     * @param array $all
     * @param $charge
     * @param Event $event
     * @return mixed
     */
    private function savePayment(array $all, $charge, Event $event)
    {
        $payment = Payment::create([
            //charge
            'amount' => $charge->amount,
            'processor_transaction_id' => $charge->id,
            'processor' => env('CREDIT_CARD_PROCESSOR'),
            'status' => $charge->status,
            'token' => $all[ 'token' ][ 'id' ],

            //event
            'event_id' => $event->id,

            //attendee
            'payer_id' => 0,
            'address' => $all[ 'registrants' ][ 0 ][ 'address' ],
            'city' => $all[ 'registrants' ][ 0 ][ 'city' ],
            'state' => $all[ 'registrants' ][ 0 ][ 'state' ],
            'postal' => $all[ 'registrants' ][ 0 ][ 'postal' ],
            'country' => $all[ 'registrants' ][ 0 ][ 'country' ],

        ]);
        if ( Arr::has($all[ 'registrants' ][ 0 ], 'address_2') ) {
            $payment->address_2 = $all[ 'registrants' ][ 0 ][ 'address_2' ];
        }
        if ( Arr::has($all[ 'registrants' ][ 0 ], 'suite') ) {
            $payment->suite = $all[ 'registrants' ][ 0 ][ 'suite' ];
        }

        return $payment;
    }

    /**
     * Creates an Attendee from the information collected from the registration form
     * @param array $registrant
     * @param Event $event
     * @param Payment $payment
     * @return Attendee
     */
    private function createRegistration(array $registrant, Event $event, Payment $payment): Attendee
    {
        $eventId = $event->id;
        $paymentId = $payment->id;
        // for each attendee in the form create an Attendee

        $attendee = Attendee::create([
            'event_id' => $eventId,
            'payment_id' => $paymentId,
            'name' => $registrant[ 'name' ],
            'email' => $registrant[ 'email' ],
            'phone' => $registrant[ 'phone' ],
            'address' => $registrant[ 'address' ],
            'city' => $registrant[ 'city' ],
            'state' => $registrant[ 'state' ],
            'postal' => $registrant[ 'postal' ],
            'country' => $registrant[ 'country' ],
            'emergency_contact_name' => $registrant[ 'emergency_contact_name' ],
            'emergency_contact_phone' => $registrant[ 'emergency_contact_phone' ],
            'emergency_contact_relationship' => $registrant[ 'emergency_contact_relationship' ],
            'modifiers' => $registrant[ 'modifiers' ],
            'total' => $registrant[ 'amount' ],
        ]);

        //handle optional fields
        if ( Arr::has($registrant, 'address_2') ) {
            $attendee->address_2 = $registrant[ 'address_2' ];
        }
        if ( Arr::has($registrant, 'suite') ) {
            $attendee->suite = $registrant[ 'suite' ];
        }
        if ( Arr::has($registrant, 'modifiers') ) {
            $attendee->modifiers = $registrant[ 'modifiers' ];
        }

        if ( array_key_exists('license_number', $registrant) && $registrant[ 'license_number' ] != '' ) {
            $attendee->licenses()->create([
                'number' => $registrant[ 'license_number' ],
                'state' => $registrant[ 'license_state' ],
                'country' => $registrant[ 'license_country' ],
            ]);
        }

        return $attendee;
    }

    /**
     * Display the event registration successful page
     * @param Event $event
     * @param Payment $payment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function registered(Event $event, Payment $payment)
    {
        //todo get rid of this
        $payment_id = $payment->id;
        $attendees = Attendee::where('payment_id', $payment_id)->get();
        return view('event.registered', compact('event', 'payment', 'attendees'));
    }
}
