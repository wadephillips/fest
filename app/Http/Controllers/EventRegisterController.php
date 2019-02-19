<?php

namespace App\Http\Controllers;

use function abort;
use App\Attendee;
use App\Event;
use App\Http\Requests\EventRegistrationPostRequest;
use App\Mail\RegistrationSuccessful;
use App\Payment;
use function array_has;
use function collect;
use function dd;
use function env;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function is_null;
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
  public function show($event) //todo add type hint
  {
    return view('event.register');
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

      $description = (isset($all[ 'description' ])) ? $all['description ']: 'Event Charge';

      // validate - done with request
      // attempt to charge the card
      $tokenId = $all[ 'token' ][ 'id' ];
      $total = $all[ 'total' ];
      $charge = null;

      $charge = $this->chargeStripeToken($tokenId, $total, $description);
//      var_dump($charge);
      $paymentAndAttendees = null;

      if ( is_null($charge) ) {
        //we've got a problem throw an error nothing happened at all
        //
      } elseif ( !$charge ) {
        //we're missing the token or an amount and should return a error
      } elseif ( $charge instanceof Charge ) {
        // do all the persisting in a transaction
        $paymentAndAttendees = $this->saveRegistrationAndPayment($all, $charge, $event);
      } else {
        throw new Exception('');
      }
//      dd($paymentAndAttendees);
      //if successful persist payment info, attendee info, and then send email to queue, display thank you page
      //log the payment to and the registration

      // send email
//      dd($paymentAndAttendees['attendees']);
      //todo: resume: why is $attendees not available in the emails.registration.blade template? Getting an error when we run a test
      Mail::to($all['token']['email'])->send(new RegistrationSuccessful($paymentAndAttendees['attendees'], $paymentAndAttendees['payment']));


    } catch ( Exception $e ) {
      echo $e->getMessage();
      echo $e->getTraceAsString();

    }

    // else return them to the registration form with some error message
    return response($request->all(), 200);
  }

  /**
   * @param Event $event
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function registered($event) //todo add type hint
  {
    return response($event, 200);
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
    $payment = $this->savePayment($all, $charge, $event); //App\Payment
    $attendees = [];
    foreach ( $all[ 'registrants' ] as $registrant ) {
      $attendees[] = $this->createRegistration($registrant, $event, $payment); // array of attendees with first being the payor
    }
    $payment->payer_id = $attendees[0]->id;
    $payment->save();

    return ['payment' => $payment, 'attendees' => $attendees];

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
          'emergency_contact_relation' => $registrant['emergency_contact_relation'],
//          'modifiers' => $registrant['modifiers'],
          'total' => $registrant['total'],
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

    return $attendee;
  }
}
