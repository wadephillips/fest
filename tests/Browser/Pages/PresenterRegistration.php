<?php

namespace Tests\Browser\Pages;

use App\Event;
use Laravel\Dusk\Browser;

class PresenterRegistration extends Page
{
  protected $event;

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
      $this->event = Event::findOrFail(1);
        return $this->event->presenterUrl;
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertUrlIs($this->url());
        $browser->assertSee('Presenter Registration ');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@presenter-radio' => 'input[id^="attendee_0_registration_type"]',
        ];
    }
}
