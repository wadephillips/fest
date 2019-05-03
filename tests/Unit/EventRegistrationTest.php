<?php

namespace Tests\Unit;

use App\Attendee;
use App\Event;
use App\Http\Controllers\EventRegisterController;
use App\Payment;
use App\User;
use function array_merge;
use Exception;
use function factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function is_object;
use function json_decode;
use function print_r;
use ReflectionClass;
use function str_random;
use Stripe\Charge;
use Stripe\Error\Card;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function var_dump;

class EventRegistrationTest extends TestCase
{
  private $registrants = [];
  private $event;
  private $formData;
  private $stripeData;
  private $post;

  protected function setUp()
  {
    parent::setUp();
    // create an event
    $this->event = factory(Event::class)->create([ 'name' => 'POCA Fest!!', 'slug' => 'poca-fest', ]);
    //create a registrant(s)
    $this->registrants[] = [
        'name' => 'John Jones',
        'email' => 'jjones@example.com',
        'phone' => '907-555-5555',
        'address' => '123 any st.',
        'city' => 'Anytown',
        'state' => 'AK',
        'postal' => '99501',
        'country' => 'US',
        'emergency_contact_name' => 'James Jones',
        'emergency_contact_phone' => '406-555-5555',
        'emergency_contact_relationship' => 'father',

        'license_number' => '213',
        'license_country' => 'US',
        'license_state' => 'AK',

        'modifiers' => [
            'meal' => [
                'type' => 'Omnivore',
            ],
            'payment' => [
                'one_day_pass' => 12500,
                'one_day_add_ceu' => 7500,
            ],
        ],
        'amount' => 20000,
    ];
    $this->registrants[] = [
        'name' => 'Jane Doe',
        'email' => 'janedoe@example.com',
        'phone' => '907-555-5556',
        'address' => '789 any st.',
        'city' => 'Anytown',
        'state' => 'AK',
        'postal' => '99501',
        'country' => 'US',
        'emergency_contact_name' => 'Jenny Doe',
        'emergency_contact_phone' => '406-555-5556',
        'emergency_contact_relationship' => 'Mother',

        'license_number' =>  '',
        'license_country' => '',
        'license_state' => '',

        'modifiers' => [
            'meal' => [
                'other_food' => 'Gluten Free plz',
                'type' => 'Vegan',
            ],
            'payment' => [
                'three_day_overnight_pass' => 30000,
            ],
        ],
        'amount' => 30000,
    ];
    //create the form data
    $this->formData = [
    ];

    $this->stripeData = \GuzzleHttp\json_decode(
        '{
              "token": {
                "id": "tok_visa",
                "object": "token",
                "card": {
                  "id": "card_1E4D7BEfCmJMLhhrncimuMLh",
                  "object": "card",
                  "address_city": "Anytown",
                  "address_country": "US",
                  "address_line1": "123 any st.",
                  "address_line1_check": "pass",
                  "address_line2": null,
                  "address_state": null,
                  "address_zip": "99501",
                  "address_zip_check": "pass",
                  "brand": "Visa",
                  "country": "US",
                  "cvc_check": "pass",
                  "dynamic_last4": null,
                  "exp_month": 11,
                  "exp_year": 2020,
                  "funding": "credit",
                  "last4": "4242",
                  "metadata": {},
                  "name": "jjones@example.com",
                  "tokenization_method": null
                },
                "client_ip": "173.244.44.41",
                "created": 1550261813,
                "email": "jjones@example.com",
                "livemode": false,
                "type": "card",
                "used": false
              },
              "args": {}
            }'
        , true);

    $this->post = $post = array_merge($this->formData, $this->stripeData, [ 'total' => 45000 ]);
    $this->post[ 'registrants' ] = $this->registrants;
//    dd($this->post);

  }


  public function testItPostsStuffToTheRoute()
  {
      $path = '/events/' . $this->event->slug . '/register';
      $response = $this->post($path, $this->post);
//      dd($response);
//      $emails = app()->make('swift.transport')->driver()->messages();
//      $this->assertCount(1, $emails);
//      $this->assertEquals([ $this->stripeData[ 'token' ][ 'email' ] ], array_keys($emails[ 0 ]->getTo()));
      $response->assertOk();

  }

  public function testItPostsABadCardToTheRoute()
  {
    try {
      $path = '/events/' . $this->event->slug . '/register';
      $this->post['token']['id'] = 'tok_chargeDeclined';
      $response = $this->post($path, $this->post);
      $content = $response->getOriginalContent();

      $response->assertStatus(402);

      $response->assertJson($content);
      $response->assertJsonFragment(['message' => 'Your card was declined.']);
    } catch ( Exception $e ) {
//      echo $e->getMessage();
    }
  }

  public function testItPostsACardWithInsufficientFundsToTheRoute()
  {
    try {
      $path = '/events/' . $this->event->slug . '/register';
      $this->post['token']['id'] = 'tok_chargeDeclinedInsufficientFunds';
      $response = $this->post($path, $this->post);
      $content = $response->getOriginalContent();

      $response->assertStatus(402);

      $response->assertJson($content);
      $response->assertJsonFragment(['message' => 'Your card has insufficient funds.']);
    } catch ( Exception $e ) {
      echo $e->getMessage();
    }
  }

  public function testItValidatesDataAndReturns422ResponseWhenInvalidDataIsPosted()
  {
//    $this->withoutExceptionHandling();
    Mail::fake();
      $path = '/events/' . $this->event->slug . '/register';
    $this->post['registrants'][0][ 'name' ] = str_random(105);
//    print_r($this->post);
      $response = $this->postJson($path, $this->post);
//      var_dump($response->getStatusCode());
    $response->assertStatus(422);
      $response->assertJsonValidationErrors('registrants.0.name');


  }


  public function testItChargesAStripeToken()
  {
    $result = $this->chargeAToken(9900, 'base charge test');
//    var_dump($result);
    $this->assertTrue(is_object($result));
    $this->assertInstanceOf(Charge::class, $result);
    $this->assertTrue($result->amount == 9900);

  }

  public function testItRejectsABadStripeToken()
  {
    $result = $this->chargeAToken(9900, 'a bad charge unit test charge', 'tok_chargeDeclined');
//    var_dump($result->getJsonBody()['error']['message']);
    $this->assertTrue(is_object($result));
    $this->assertInstanceOf(Card::class, $result);
//    print_r($result->getJsonBody());
    $this->assertTrue($result->getJsonBody()['error']['message'] == "Your card was declined.");
  }

  public function testItPersistsAPayment()
  {
    $total = 7500;
    $charge = $this->chargeAToken($total, 'charge for building a Payment test');
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod('App\Http\Controllers\EventRegisterController', 'savePayment');
    $all = $this->post;
    $all[ 'total' ] = $total;
    $result = $method->invokeArgs($controller, [ $all, $charge, $this->event ]);
    $this->assertTrue(is_object($result), 'The result is not an object');
    $this->assertInstanceOf(Payment::class, $result);
    $this->assertTrue($result->amount == 7500);
    $this->assertTrue($result->address == $this->registrants[ 0 ][ 'address' ]);
    $this->assertTrue($result->city == $this->registrants[ 0 ][ 'city' ]);
    $this->assertTrue($result->state == $this->registrants[ 0 ][ 'state' ]);
    $this->assertTrue($result->country == $this->registrants[ 0 ][ 'country' ]);

  }

  public function testItRegistersAnAttendee()
  {
    $payment = factory(Payment::class)->create([
        'event_id' => $this->event->id,
        'payer_id' => 0,
        'processor' => 'stripe',
        'processor_transaction_id' => 'ch_1E5LXbLHPlwTNNkcbl0czjGQ',
    ]);
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod('App\Http\Controllers\EventRegisterController', 'createRegistration');

    $result = $method->invokeArgs($controller, [ $this->registrants[ 0 ], $this->event, $payment ]);

    $this->assertTrue($result->name == $this->registrants[ 0 ][ 'name' ]);
    $this->assertTrue($result->phone == $this->registrants[ 0 ][ 'phone' ]);
    $this->assertTrue($result->postal == $this->registrants[ 0 ][ 'postal' ]);
    $this->assertTrue($result->address == $this->registrants[ 0 ][ 'address' ]);
    $attendeeId = $result->id;
    $attendeeDB = Attendee::findOrFail($attendeeId);
    $this->assertTrue($attendeeDB->name == $this->registrants[ 0 ][ 'name' ]);
    $this->assertTrue($attendeeDB->phone == $this->registrants[ 0 ][ 'phone' ]);
    $this->assertTrue($attendeeDB->postal == $this->registrants[ 0 ][ 'postal' ]);
    $this->assertTrue($attendeeDB->address == $this->registrants[ 0 ][ 'address' ]);
  }

  /**
   * @param $price
   * @return mixed
   */
  private function chargeAToken(int $price = 9999,
                                string $description = 'This is a unit test charge',
                                string $token = 'tok_visa'
  )
  {
    $amount = $price;
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod('App\Http\Controllers\EventRegisterController', 'chargeStripeToken');

    $result = $method->invokeArgs($controller, [ $token, $amount, $description ]);
    return $result;
  }

}
