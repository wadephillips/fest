<?php

namespace Tests\Unit;

use App\Attendee;
use App\Event;
use function dd;
use function factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventTest extends TestCase
{
  use DatabaseMigrations;

  public function testItHasAnAttendeeCount()
  {
    $this->withoutExceptionHandling();

    //given we have and event with attendees
    $event = factory(Event::class)->create();
    $attendees = factory(Attendee::class, 10)->create(['event_id' => $event->id]);
    //it has can  tell us how many attendees there are

    $foundEvent = Event::find($event->id);
    $foundEvent->load('attendees');

    $this->assertTrue($foundEvent->attendeeCount  == 10);
  }




}
