<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationFormTest extends DuskTestCase
{
  private $url;

  protected function setUp()
  {
    parent::setUp();
    $this->url = '/events/fest/register';
  }

  /**
   * A Dusk test example.
   *
   * @return void
   */
  public function testVisitTheRegistrationPage()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->assertSee('Register for Poca Fest Test');
    });
  }

  public function testRegisterOneApplicant()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->type('#attendee_0_name', 'John Doe')
          ->type('#attendee_0_email', 'jdoe@pocacoop.com')
          ->type('#attendee_0_phone', '907 555 0000')
          ->type('#attendee_0_address', '123 Any St.')
          ->type('#attendee_0_city', 'Anytown')
          ->select('#attendee_0_state', 'AK')
          ->type('#attendee_0_postal', '99502')
          ->select('#attendee_0_country', 'US')
          ->type('#attendee_0_emergency_contact_name', 'Jonathan Doe')
          ->type('#attendee_0_emergency_contact_phone', '907 551 5555')
          ->type('#attendee_0_emergency_contact_relationship', 'father')
//          ->check('#0-acu-switch')
//          ->assertSee('Acupuncture License Info')
//          ->select('#attendee_0_license_state', 'AK')
//          ->type('#attendee_0_license_number', '213')
//          ->select('#attendee_0_license_country', 'US')
          ->assertSee('Checkout @ ')
          ->click('@checkout-button')
//          //todo resume: fill out the stripe form
          ->waitFor('iframe[name=stripe_checkout_app]');

      $browser->driver->switchTo()->frame('stripe_checkout_app');

//
//      $b
      $browser->type('input[placeholder="Email"]', 'jdoe@pocacoop.com');
      $browser->pause(1000);
      $browser->keys('input[placeholder="Card number"]', '4242')
          ->append('input[placeholder="Card number"]', '4242')
          ->append('input[placeholder="Card number"]', '4242')
          ->append('input[placeholder="Card number"]', '4242')
          ->pause(200);
      $browser
          ->keys('input[placeholder="MM / YY"]', '11')
          ->append('input[placeholder="MM / YY"]', '20');
      $browser->type('input[placeholder="CVC"]', '123')
//          ->keys('input[placeholder="ZIP Code"]', '55555')
//
          ->assertSee('POCA Fest Registration')
//          ->press('Pay with Card $200.42')
          ->waitUntilMissing('iframe[name=stripe_checkout_app]');

          $browser->driver->switchTo()->defaultContent();



    });

  }
}
