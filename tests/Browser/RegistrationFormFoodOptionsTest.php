<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationFormFoodOptionsTest extends DuskTestCase
{

  private $url;

  protected function setUp()
  {
    parent::setUp();
    $this->url = '/events/fest/register';
  }

    public function testSelectingFoodOptionsSetsTheLocalVueModel()
    {
      $this->browse(function (Browser $browser) {
        $browser->visit($this->url)
            ->assertSee('Register for Poca Fest Test');

        $browser->radio('meal.type', 'Omnivore')
            ->type('#attendee_0_other_food', "I'm a Gluten Free panda, please");
        $browser->assertVue('model.meal.type', 'Omnivore', '@poca-fest-options-0')
        ->assertVue('model.meal.other_food', "I'm a Gluten Free panda, please", '@poca-fest-options-0')
        ;
      });
    }

  public function testSelectingFoodOptionsSetsTheRegistrationFormModel()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->assertSee('Register for Poca Fest Test');

      $browser->radio('meal.type', 'Omnivore')
          ->type('#attendee_0_other_food', "I'm a Gluten Free panda, please");

      $browser->assertVue('formModels[0].modifiers.meal.type', 'Omnivore', '@registration-form')
          ->assertVue('formModels[0].modifiers.meal.other_food', "I'm a Gluten Free panda, please", '@registration-form')
      ;
    });
  }


}
