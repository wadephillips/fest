<?php

namespace Tests\Unit;

use App\Event;
use App\Http\Controllers\EventRegisterController;
use function array_merge;
use Exception;
use function factory;
use Illuminate\Support\Facades\App;
use function is_object;
use function json_decode;
use ReflectionClass;
use Stripe\Charge;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function var_dump;

class EventRegistrationTest extends TestCase
{
  private $registrant;
  private $event;
  private $formData;
  private $stripeData;

  protected function setUp()
  {
    parent::setUp();
    // create an event
    $this->event = factory(Event::class)->create([ 'name' => 'POCA Fest!!', 'slug' => 'poca-fest',]);
    //create a registrant(s)
    $this->registrant = [
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
        'emergency_contact_relation' => 'father',
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
                  "address_city": null,
                  "address_country": null,
                  "address_line1": null,
                  "address_line1_check": null,
                  "address_line2": null,
                  "address_state": null,
                  "address_zip": null,
                  "address_zip_check": null,
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


  }


  public function testItPostsStuffToTheRoute()
  {
    try {
      $path = '/events/' . $this->event->slug . '/register';
    $post = array_merge($this->registrant, $this->formData, $this->stripeData, [ 'total' => 15000 ]);//    var_dump($path);
      $response = $this->post($path, $post);
      $response->assertOk();
    } catch ( Exception $e ) {
      echo $e->getMessage();
      echo $e->getTraceAsString();
    }
  }
  public function testItChargesAStripeToken()
  {
    $token='tok_visa';
    $amount = '9900';
    $description = 'This is a unit test charge';

    ;
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod('App\Http\Controllers\EventRegisterController', 'chargeStripeToken');

    $result = $method->invokeArgs($controller, [$token,$amount, $description]);

    $this->assertTrue(is_object($result));
    $this->assertInstanceOf(Charge::class, $result);
    $this->assertTrue($result->amount == 9900);

  }

}
