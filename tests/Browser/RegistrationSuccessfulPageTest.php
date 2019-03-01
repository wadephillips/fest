<?php

namespace Tests\Browser;

use App\Attendee;
use App\Payment;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationSuccessfulPageTest extends DuskTestCase
{
  private $url;


  private $attendees = [];

  private $payment;

  protected function setUp()
  {
    parent::setUp();
    $this->url = '/events/fest/registered';

//    $this->payment = Payment::find(7)->toJson;
//    $this->attendees[] = Attendee::find
  }

  public function testPageExists()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit($this->url)
          ->assertSee("You're going to POCA Fest!");
    });
  }


}
