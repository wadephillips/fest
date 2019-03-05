<?php

namespace Tests\Browser;

use Tests\Browser\Pages\RegisterFest;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OtherThingsFieldTest extends DuskTestCase
{
    
    public function testItAcceptsInput()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterFest())
                ->type('#attendee_0_other_info', 'This is the story of a man named Brady')
                ->assertInputValue('#attendee_0_other_info', 'This is the story of a man named Brady')
            ;
        });
    }
    
    public function testItPassesInputToTheRegistrationFormModel()
      {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterFest())
                ->type('#attendee_0_other_info', 'This is the story of a man named Brady')
                ->assertVue('formModels[0].modifiers.other','This is the story of a man named Brady', '@registration-form')
                ->addAttendee()
            ;

//          $browser;
          $browser->assertSeeIn('@attendee-total-1', '$0.00');


            $browser
                ->type('#attendee_1_other_info', 'Who was bringing up three very lovely girls')
                ->assertVue('formModels[1].modifiers.other','Who was bringing up three very lovely girls', '@registration-form');
            ;
        });
    }

    public function testTypingInTheFieldDoesntAlterOtherPartsOfTheModel()
      {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegisterFest())
                ->radio('registration_type', 'three_day_day_only')
                ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 25000, '@registration-form')
                ->type('#attendee_0_other_info', 'This is the story of a man named Brady')
                ->assertVue('formModels[0].modifiers.other','This is the story of a man named Brady', '@registration-form')
                ->assertVue('formModels[0].modifiers.payment.three_day_day_only.value', 25000, '@registration-form')
            ;
        });
    }
}
