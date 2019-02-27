<?php

namespace App\Http\Controllers;

use function abort;
use App\Attendee;
use App\Event;
use App\Http\Requests\EventRegistrationPostRequest;
use App\License;
use App\Mail\RegistrationSuccessful;
use App\Payment;
use function array_has;
use function array_key_exists;
use function collect;
use function compact;
use function dd;
use function env;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use function is_null;
use function print_r;
use stdClass;
use Stripe\Charge;
use Stripe\Stripe;
use function var_dump;

class EventRegisterController extends Controller
{


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }


  /**
   * Display the specified resource.
   *
   * @param Event $event
   * @return \Illuminate\Http\Response
   */
  public function show(Event $event)
  {

    return view('event.register', compact('event'));
  }

  /**
   * Process an event registration.
   *
   * @param  \Illuminate\Http\Request $request
   * @param Event $event
   * @return \Illuminate\Http\Response
   * //EventRegistrationPostRequest
   */
  public function register(Request $request, Event $event)
  {
    try {
      $all = $request->all();

//      print_r($all);

      $description = (array_key_exists('description', $all)) ? $all['description']: 'Event Charge';

      //todo CRITICAL pre-launch need to validate - done with request, but the request isn't being called right now
      // attempt to charge the card
      $tokenId = $all[ 'token' ][ 'id' ];
      $total = $all[ 'total' ];
      $charge = null;

      $charge = $this->chargeStripeToken($tokenId, $total, $description);
      $paymentAndAttendees = null;

      if ( is_null($charge) ) {
        //todo we've got a problem throw an error nothing happened at all
        throw new Exception('Nothing happened when attempting to charge the token');
        //
      } elseif ( !$charge ) {
        //todo we're missing the token or an amount and should return a error
        throw new Exception('The charge returned false while attempting to charge the token');
      } elseif ( $charge instanceof Charge ) {
        // do all the persisting in a transaction
        $paymentAndAttendees = $this->saveRegistrationAndPayment($all, $charge, $event);
      } else {
        throw new Exception('There is a general problem processing the charge');
      }
      //if successful persist payment info, attendee info, and then send email to queue, display thank you page
      //todo log the payment to and the registration

      // send email
      Mail::to($all['token']['email'])->send(new RegistrationSuccessful($paymentAndAttendees['attendees'], $paymentAndAttendees['payment']));
//      dd($mail);


      // else return them to the registration form with some error message
      return response($paymentAndAttendees, 201);

    } catch ( Exception $e ) {
      echo $e->getMessage();
      echo $e->getTraceAsString();

      return abort(400, $e->getMessage());

    }

  }

  /**
   * @param Event $event
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function registered(Event $event)
  {
    //todo get rid of this
    $payment = Payment::find(7);
    $attendees = Attendee::where('payment_id', 7)->get();
    return view('event.registered', compact('event', 'payment', 'attendees'));
//        response($event, 200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  private function chargeStripeToken($tokenId, $total, $description)
  {
    try {
      $charge = false;

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
      //TODO: log all declines to a DB table, set up error logging

      print('Status is:' . $e->getHttpStatus() . "\n");
      print('Type is:' . $err[ 'type' ] . "\n");
      print('Code is:' . $err[ 'code' ] . "\n");
      // param is '' in this case
      print('Param is:' . $err[ 'param' ] . "\n");
      print('Message is:' . $err[ 'message' ] . "\n");
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

  private function saveRegistrationAndPayment(array $all, $charge, Event $event)
  {

    try {
      DB::beginTransaction();
      $payment = $this->savePayment($all, $charge, $event);//App\Payment
      $attendees = [];
      foreach ( $all[ 'registrants' ] as $registrant ) {
        //todo resume: test to ensure that the modifiers are being registered for all attendees
        $attendees[] = $this->createRegistration($registrant, $event, $payment); // array of attendees with first being the payor
      }
      $payment->payer_id = $attendees[ 0 ]->id;
      $payment->save();
      DB::commit();
      return [ 'payment' => $payment, 'attendees' => $attendees ];
    } catch ( Exception $e ) {
      DB::rollBack();
      throw new Exception('There was a problem persisting the registration or payment: ' . $e->getMessage(), 0, $e);
    }

  }

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
    if ( array_has($all[ 'registrants' ][ 0 ], 'address_2') ) {
      $payment->address_2 = $all[ 'registrants' ][ 0 ][ 'address_2' ];
    }
    if ( array_has($all[ 'registrants' ][ 0 ], 'suite') ) {
      $payment->suite = $all[ 'registrants' ][ 0 ][ 'suite' ];
    }

    return $payment;
  }

  private function createRegistration(array $registrant, Event $event, Payment $payment): Attendee
  {
    $eventId = $event->id;
    $paymentId = $payment->id;
    // for each attendee in the form create an Attendee

      $attendee = Attendee::create([
          'event_id' => $eventId,
          'payment_id' => $paymentId,
          'name' => $registrant['name'],
          'email' => $registrant['email'],
          'phone' => $registrant['phone'],
          'address' => $registrant['address'],
          'city' => $registrant['city'],
          'state' => $registrant['state'],
          'postal' => $registrant['postal'],
          'country' => $registrant['country'],
          'emergency_contact_name' => $registrant['emergency_contact_name'],
          'emergency_contact_phone' => $registrant['emergency_contact_phone'],
          'emergency_contact_relationship' => $registrant['emergency_contact_relationship'],
          'modifiers' => $registrant['modifiers'],
          'total' => $registrant['amount'],
      ]);

    if ( array_has($registrant, 'address_2') ) {
      $attendee->address_2 = $registrant[ 'address_2' ];
    }
    if ( array_has($registrant, 'suite') ) {
      $attendee->suite = $registrant[ 'suite' ];
    }
    if ( array_has($registrant, 'modifiers') ) {
      $attendee->modifiers = $registrant[ 'modifiers' ];
    }

    if ($registrant['license_number'] != '') {
      $attendee->licenses()->create([
          'number' => $registrant['license_number'],
          'state' => $registrant['license_state'],
          'country' => $registrant['license_country'],
      ]);
    }

    return $attendee;
  }
}
