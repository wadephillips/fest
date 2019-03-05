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
          ->keys('@0-acu-switch', ['{space}'])
          ->waitFor('@0-acu-license-form')
          ->assertSee('Acupuncture License Info')
          ->select('#attendee_0_license_state', 'AK')
          ->type('#attendee_0_license_number', '213')
          ->select('#attendee_0_license_country', 'US')
          ->assertSee('Pay and Register for ')
          ->click('@checkout-button')

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

  public function testRegisterTwoAttendees()
  {
    $this->browse(function (Browser $browser) {
      //first attendee
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
          ->keys('@0-acu-switch', ['{space}'])
          ->waitFor('@0-acu-license-form')
          ->assertSee('Acupuncture License Info')
          ->select('#attendee_0_license_state', 'AK')
          ->type('#attendee_0_license_number', '213')
          ->select('#attendee_0_license_country', 'US')

          ->radio('registration_type', 'three_day_day_only')
          ->assertSee('Sliding Scale, set your price - Three Day Pass - No Overnight Stay - $250 - $500')
          ->dragRight('.irs-single', 50)

          ->radio('food.type', 'Omnivore');

      // add an attendee
      $browser->press('@add-attendee-btn');


      //second attendee
      $browser->visit($this->url)
          ->type('#attendee_1_name', 'Jane Doe')
          ->type('#attendee_1_email', 'janedoe@pocacoop.com')
          ->type('#attendee_1_phone', '907 555 0001')
          ->type('#attendee_1_address', '123 Any St.')
          ->type('#attendee_1_city', 'Anytown')
          ->select('#attendee_1_state', 'AK')
          ->type('#attendee_1_postal', '99502')
          ->select('#attendee_1_country', 'US')
          ->type('#attendee_1_emergency_contact_name', 'Nancy Doew')
          ->type('#attendee_1_emergency_contact_phone', '907 551 5555')
          ->type('#attendee_1_emergency_contact_relationship', 'mother in law')


          ->radio('registration_type', 'fso_adult')
//          ->assertDontSee('Sliding Scale, set your price - Three Day Pass - No Overnight Stay - $250 - $500')
//          ->dragRight('.irs-single', 50)

          ->radio('food.type', 'Omnivore')
          ->type('attendee_1_other_food', "I'm a Gluten Free panda, please");

      $browser->assertVue('formModels[1].modifiers.meal.type.description', 'Omnivore', '@RegistrationForm');

    });


  }


  public function testItHasAFormForEventRegistrationOptions()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
        ->assertSee('Poca Fest')
      ->assertSee('Registration options for this attendee')
      ->assertSee('Three Day Pass - Overnight Stay')
      ->assertSee('Three Day Pass - No Overnight Stay')
      ->assertSee('Ear Training - 3 Day Pass - Overnight Stay')
      ->assertSee('Ear Training - 3 Day Pass - No Overnight Stay')
      ->assertSee('Student - 3 Day Pass')
      ->assertSee('Additional Family Member / Significant Other - Adult')
      ->assertSee('Additional Family Member / Significant Other - Child')
      ->assertSee('One Day Only Pass')
          ->assertDontSee('Sliding Scale, set your price -')
          ->assertDontSee('I need to add CEUs to my one day pass.')
      ;
      $browser->radio('registration_type', 'three_day_overnight_pass')
      ->assertSee('Sliding Scale, set your price - Three Day Pass - Overnight Stay - $250 - $500')
      ->assertVue('model.chosen.three_day_overnight_pass.value', 30000, '@poca-fest-options-0')
      ->assertDontSee('I need to add CEUs to my one day pass.');

      $browser->radio('registration_type', 'three_day_day_only')
      ->assertSee('Sliding Scale, set your price - Three Day Pass - No Overnight Stay - $250 - $500')
      ->assertVue('model.chosen.three_day_day_only.value', 25000, '@poca-fest-options-0')
      ->assertDontSee('I need to add CEUs to my one day pass.');

      $browser->radio('registration_type', 'ear_training_overnight')
      ->assertSee('Sliding Scale, set your price - Ear Training - 3 Day Pass - Overnight Stay - $250 - $500')
            ->assertVue('model.chosen.ear_training_overnight.value', 30000, '@poca-fest-options-0')
      ->assertDontSee('I need to add CEUs to my one day pass.');

      $browser->radio('registration_type', 'ear_training_day_only')
      ->assertSee('Sliding Scale, set your price - Ear Training - 3 Day Pass - No Overnight Stay - $200 - $500')
            ->assertVue('model.chosen.ear_training_day_only.value', 25000, '@poca-fest-options-0')
      ->assertDontSee('I need to add CEUs to my one day pass.');

      $browser->radio('registration_type', 'student')
      ->assertSee('Sliding Scale, set your price - Student - 3 Day Pass - $100 - $200')
            ->assertVue('model.chosen.student.value', 15000, '@poca-fest-options-0')
          ->assertDontSee('I need to add CEUs to my one day pass.');

      $browser->radio('registration_type', 'fso_adult')
          ->assertDontSee('Sliding Scale, set your price -');

      $browser->radio('registration_type', 'fso_child')
          ->assertDontSee('Sliding Scale, set your price -');

      $browser->radio('registration_type', 'one_day_pass')
          ->assertSee('Sliding Scale, set your price - One Day Pass- $100 - $200')
          ->assertSee('I need to add CEUs to my one day pass.')
          ->check('#attendee_0_one_day_add_ceu')
          ->assertVue('model.chosen.one_day_pass.value', 12500, '@poca-fest-options-0')
          ->assertVue('model.chosen.one_day_add_ceu.value', 7500, '@poca-fest-options-0')
          ;

    });
  }

  public function testSliderSetFunctionsMultiplyValueBy100()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->assertSee('Poca Fest');

      $browser->radio('registration_type', 'three_day_overnight_pass')
          ->assertSee('Sliding Scale, set your price - Three Day Pass - Overnight Stay - $250 - $500')
          ->dragRight('.irs-single', 10)
//          ->assertVue('wade','the bomb', '@poca-fest-options-0')
          ->assertVue('model.chosen.three_day_overnight_pass.value', 30300, '@poca-fest-options-0')
      ;
    });
  }

  public function testChoosingAFoodOptionDoesntChangePriceRangeSelection()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->assertSee('Poca Fest');

      $browser->radio('registration_type', 'three_day_overnight_pass')
          ->assertSee('Sliding Scale, set your price - Three Day Pass - Overnight Stay - $250 - $500')
          ->dragRight('.irs-single', 10)
//          ->assertVue('wade','the bomb', '@poca-fest-options-0')
          ->assertVue('model.chosen.three_day_overnight_pass.value', 30300, '@poca-fest-options-0');

      $browser->radio('food.type', 'Vegan')
        ->assertVue('model.chosen.three_day_overnight_pass.value', 30300, '@poca-fest-options-0');

    });
  }


}
