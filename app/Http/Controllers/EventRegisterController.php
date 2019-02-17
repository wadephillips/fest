<?php

namespace App\Http\Controllers;

use function abort;
use App\Event;
use App\Http\Requests\EventRegistrationPostRequest;
use function env;
use Exception;
use Illuminate\Http\Request;
use function is_null;
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
   */
  public function register(EventRegistrationPostRequest $request, Event $event)
  {
    try {
      $all = $request->all();
      $description = (isset($all[ 'description' ])) ? $all->description : 'Event Charge';

      // validate - done with request
      // attempt to charge the card
      $tokenId = $all[ 'token' ][ 'id' ];
      $total = $all[ 'total' ];
      $charge = null;

      $charge = $this->chargeStripeToken($tokenId, $total, $description);
      var_dump($charge);

      if (is_null($charge)) {
        //we've got a problem throw an error nothing happened at all
        //
      } elseif (!$charge) {
        //we're missing the token or an amount and should return a error
      } elseif ($charge instanceof Charge) {
        // do all the persisting in a transaction
        $this->saveRegistrationAndPayment($all, $charge);
      } else {
        throw new Exception('');
      }




    } catch ( Exception $e ) {
      echo $e->getMessage();
      echo $e->getTraceAsString();

    }
    //if successful persist payment info, attendee info, and then send email to queue, display thank you page
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
    } catch(\Stripe\Error\Card $e) {
      // Since it's a decline, \Stripe\Error\Card will be caught
      $body = $e->getJsonBody();
      $err  = $body['error'];
      //TODO: log all declines to a DB table, set up error logging

      print('Status is:' . $e->getHttpStatus() . "\n");
      print('Type is:' . $err['type'] . "\n");
      print('Code is:' . $err['code'] . "\n");
      // param is '' in this case
      print('Param is:' . $err['param'] . "\n");
      print('Message is:' . $err['message'] . "\n");
    } catch (\Stripe\Error\RateLimit $e) {
      // Too many requests made to the API too quickly
    } catch (\Stripe\Error\InvalidRequest $e) {
      // Invalid parameters were supplied to Stripe's API
    } catch (\Stripe\Error\Authentication $e) {
      // Authentication with Stripe's API failed
      // (maybe you changed API keys recently)
    } catch (\Stripe\Error\ApiConnection $e) {
      // Network communication with Stripe failed
    } catch (\Stripe\Error\Base $e) {
      // Display a very generic error to the user, and maybe send
      // yourself an email
    }
  }

  private function saveRegistrationAndPayment(array $all, $charge)
  {
    $payment = $this->savePayment($all, $charge); //App\Payment

    $attendees = $this->saveRegistration($all); // array of attendees with first being the payee
  }

  private function savePayment(array $all, $charge)
  {
    $this->
  }
}
