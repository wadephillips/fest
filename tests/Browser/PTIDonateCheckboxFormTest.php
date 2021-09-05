<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PTIDonateCheckboxFormTest extends DuskTestCase
{
    private $url;

    protected function setUp()
    {
        parent::setUp();
        $this->url = '/events/fest/register';
    }

    public function testPocaTechCheckBoxInitialState()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
                    ->assertSee('Poca Fest Test')
                    ->assertSee("I'd like to support affordable Acupuncture Education by donating $5 to POCA Tech!")
                ->assertNotChecked('#attendee_0_poca_tech_donation');
        });
    }

    public function testPocaTechCheckBoxCheckingThisChangesTheModel()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
          ->assertNotChecked('#attendee_0_poca_tech_donation')
          ->check('#attendee_0_poca_tech_donation')
          ->assertChecked('#attendee_0_poca_tech_donation')
          ->assertVue('model.chosen.poca_tech_donation.value', 500, '@poca-fest-options-0')
          ->assertVue('model.chosen.poca_tech_donation.description', 'Donate $5 to POCA Tech', '@poca-fest-options-0')
          ->assertVue('attendees', 1, '@registration-form')
          ->assertVue('formModels[0].modifiers.payment.poca_tech_donation.value', 500, '@registration-form')
          ->assertVue('formModels[0].modifiers.payment.poca_tech_donation.description', 'Donate $5 to POCA Tech', '@registration-form');
        });
    }

    public function testItDoesNotChangeOtherSelctionsOnTheForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
          ->radio('registration_type', 'three_day_day_only')
          ->assertSee('Sliding Scale, set your price - Three Day Pass - No Overnight Stay - $250 - $500')
          ->dragRight('.field-rangeSlider > label[for=attendee_0_rs_three_day_day_only] ~ .field-wrap .irs-single', 50)
          ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 26900, '@registration-form')
          ->check('#attendee_0_poca_tech_donation')
          ->assertVue('formModels[0].modifiers.payment.poca_tech_donation.value', 500, '@registration-form')
          ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 26900, '@registration-form')->assertVue('formModels[0].amount', 27400, '@registration-form')
          ->uncheck('#attendee_0_poca_tech_donation')
          ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 26900, '@registration-form')->assertVue('formModels[0].amount', 26900, '@registration-form');
        });
    }

    public function testItDoesntGetLostFromTheModelWhenAUserChangesOneOfTheirOtherOptions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
              ->radio('registration_type', 'three_day_day_only')
              ->assertSee('Sliding Scale, set your price - Three Day Pass - No Overnight Stay - $250 - $500')
              ->dragRight('.field-rangeSlider > label[for=attendee_0_rs_three_day_day_only] ~ .field-wrap .irs-single', 50)
              ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 26900, '@registration-form')
              ->check('#attendee_0_poca_tech_donation')
              ->assertVue('formModels[0].modifiers.payment.poca_tech_donation.value', 500, '@registration-form')
              ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 26900, '@registration-form')->assertVue('formModels[0].amount', 27400, '@registration-form')
              ->radio('registration_type', 'student')
              ->assertVue('formModels[0].modifiers.payment.student.value', 15000, '@registration-form')
              ->assertVue('formModels[0].modifiers.payment.poca_tech_donation.value', 500, '@registration-form');
        });
    }

    public function testUncheckingItRemovesItsPriceFromTheFormModelAndDecreasesTheTotal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
              ->check('#attendee_0_poca_tech_donation')
              ->assertVue('formModels[0].modifiers.payment.poca_tech_donation.value', 500, '@registration-form')
              ->assertVue('total', 500, '@registration-form')
              ->uncheck('#attendee_0_poca_tech_donation')
              ->assertVue('total', 0, '@registration-form')
//              ->assertVue('formModels[0].modifiers.payment', , '@registration-form')
;
        });
    }
}
