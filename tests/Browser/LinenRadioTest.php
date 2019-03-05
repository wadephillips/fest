<?php

namespace Tests\Browser;

use Tests\Browser\Pages\RegisterFest;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LinenRadioTest extends DuskTestCase
{
  /**
   * A Dusk test example.
   *
   * @return void
   */
  public function testItHasRadioButtonsForLinensForMultipleRegistrants()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit(new RegisterFest());

      $browser->assertSeeIn('@poca-fest-options-0', 'Do you need linens?');

      $browser->press('@add-attendee-btn')
          ->assertSeeIn('@poca-fest-options-1', 'Do you need linens?');

      $browser->radio('linens', 'Yes');
      $browser->radio('input[id^="attendee_1_linens"][value=Yes]', 'Yes');


      $browser->assertVue('formModels[0].modifiers.linens.description', 'Yes', '@registration-form');
      $browser->assertVue('formModels[1].modifiers.linens.description', 'Yes', '@registration-form');
      $browser->assertSeeIn('@attendee-total-0', '$15.00');
      $browser->assertSeeIn('@attendee-total-1', '$15.00');
      $browser->assertVue('total', 3000,'@registration-form');

      $browser->radio('input[id^="attendee_0_linens"][value=No]', 'No');

      $browser->assertVue('formModels[0].modifiers.linens.description', 'No', '@registration-form');
      $browser->assertVue('formModels[1].modifiers.linens.description', 'Yes', '@registration-form');
      $browser->assertSeeIn('@attendee-total-0', '$0.00');
      $browser->assertSeeIn('@attendee-total-1', '$15.00');
      $browser->assertVue('total', 1500,'@registration-form');


    });
  }
}
