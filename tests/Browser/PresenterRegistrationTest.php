<?php

namespace Tests\Browser;

use App\Event;
use Hashids\Hashids;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\PresenterRegistration;
use Tests\DuskTestCase;

class PresenterRegistrationTest extends DuskTestCase
{
    private $salt;
    private $code;
    private $event;
    private $hashids;

    protected function setUp()
    {
        parent::setUp();
        $this->event = Event::first();
        $this->salt = env('HASH_ID_SALT', 'make it rain');
        $this->hashids = new Hashids($this->salt, 8);
        $this->code = $this->hashids->encode($this->event->id);
    }

    public function testItShowsThePresenterRegistrationFormWhenNavigatingToAValidUrl()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new PresenterRegistration());

            $browser->assertSeeIn('@poca-fest-options-0', 'Presenter Three Day Pass');
        });
    }

    public function testClickingThePresenterRadioButtonAltersTheFormModel()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new PresenterRegistration())
          ->radio('@presenter-radio', 'presenter');
            $browser->assertVue('formModels[0].modifiers.payment.presenter.value', '15000', '@registration-form');
            $browser->assertVue('formModels[0].modifiers.payment.presenter.description', 'Presenter Three Day Pass', '@registration-form');
        });
    }

    public function testItDisplaysThePresenterSliderOncePresenterRadioIsSelected()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new PresenterRegistration())
          ->assertDontSeeIn('@poca-fest-options-0', 'Sliding Scale, set your price - Presenter Three Day Pass - $100 - $300');
            $browser->radio('@presenter-radio', 'presenter');
            $browser->assertSeeIn('@poca-fest-options-0', 'Sliding Scale, set your price - Presenter Three Day Pass - $100 - $300');
        });
    }

    //  public function testMovingThePresenterSliderChangesTheFormTotal()
//  {
//    $this->browse(function (Browser $browser) {
//      $browser->visit(new PresenterRegistration())
//          ->assertVue('total', 0, '@poca-fest-options-0');
//
//      $browser->radio('@presenter-radio', 'presenter');
//
//      $browser->assertVue('total', 15000,'@registration-form');
//      //this test is broken because this selector does not work.  Not sure how to get it functioning.  It works if you change the order of the sliders in the schema in PocaFestOptions.vue
//      $browser->dragRight('label[for=attendee_0_rs_presenter] ~ .field-wrap .irs-single', 20);
//      $browser->screenshot('slider');
//
//      $browser->assertVue('model.chosen.presenter.value', 30300, '@poca-fest-options-0');
//      $browser->assertVue('total', 17500,'@registration-form');
//    });
//  }
}
