<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationFormClientValidationTest extends DuskTestCase
{
  private $url;

  protected function setUp()
  {
    parent::setUp();
    $this->url = '/events/fest/register';
  }

    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->url)
                    ->assertSee('Register for Poca Fest Test');
        });
    }

  public function testRegistrantNameFieldMustContainAName()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->assertSee('Register for Poca Fest Test');

      $browser->type('#attendee_0_name', 'w');
      $browser->keys('#attendee_0_name', ['{BACKSPACE}']);
      $browser->assertSee('This field is required!');
//      $browser->

    });

  }


}
