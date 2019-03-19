<?php

namespace Tests\Unit;

use App\Attendee;
use App\Event;
use AttendeeTableSeeder;
use function dd;
use function factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use function method_exists;
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
    $attendees = factory(Attendee::class, 10)->create([ 'event_id' => $event->id ]);
    //it has can  tell us how many attendees there are

    $foundEvent = Event::find($event->id);
    $foundEvent->load('attendees');

    $this->assertTrue($foundEvent->attendeeCount == 10);
  }

  public function testItLoadsAnAttendeeRegistrationTypeTotal()
  {
    $this->withoutExceptionHandling();
    $event = factory(Event::class)->create();
    $attendeeSeeder = new AttendeeTableSeeder($event);
    $attendeeSeeder->run();
    $event->load('attendees');

    $this->assertTrue($event->attendeeCount == 10);
    $this->assertTrue(method_exists($event, 'totalRegistrationTypes'), 'The totalRegistrationTypes method does not exist'
    );
//    $this->assertObjectHasAttribute('totalRegistrationTypes', $event);
    $types = $event->getTotalRegistrationTypes();
    $this->assertIsArray($types );
    $this->assertTrue($types['fso_adult'] == 1);
    $this->assertTrue($types['student'] == 4);

  }


}
