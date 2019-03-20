<?php

namespace Tests\Feature;

use App\Attendee;
use App\Event;
use App\User;
use function factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PermissionRoleTableSeeder;
use PermissionsTableSeeder;
use RolesTableSeeder;

use function route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventAttendeeTypeTest extends TestCase
{
  use DatabaseMigrations;

  protected function setUp()
  {
    parent::setUp();
    $this->seed(RolesTableSeeder::class);
    $this->seed(PermissionsTableSeeder::class);
    $this->seed(PermissionRoleTableSeeder::class);
  }

  public function testAnAuthorizedUserCanSeeThePage()
  {
    $this->withoutExceptionHandling();
    $user = $this->createAndBeAdminUser();
    $event = $this->buildAnEvent();

    $response = $this->get('/admin/attendees/' . $event->slug . '/registration-type/student');

    $response->assertStatus(200);

  }

  public function testItAllowsTheUserToBrowseAttendeesOfASpecificTypeForAnEvent()
  {
    $this->withoutExceptionHandling();
    $event = $this->buildAnEvent();
    $student = $this->buildAStudent($event);
    $user = $this->createAndBeAdminUser();
    $response = $this->get('/admin/attendees/' . $event->slug . '/registration-type/student');

    $response->assertStatus(200);
    $response->assertSee('Student - 3 Day Pass attendees of ' . $event->name);


  }

  public function testItDisplaysAMessageWhenThereAreNoMatchingAttendees()
  {
    $this->withoutExceptionHandling();
    $event = $this->buildAnEvent();
//    $student = $this->buildAStudent($event);
    $user = $this->createAndBeAdminUser();
    $response = $this->get('/admin/attendees/' . $event->slug . '/registration-type/student');

    $response->assertStatus(200);
    $response->assertSee('There are no attendees registered for this type');


  }

  public function testDisplaysTheAttendeesNames()
  {
    $this->withoutExceptionHandling();
    $event = $this->buildAnEvent();
    $student = $this->buildAStudent($event);
    $user = $this->createAndBeAdminUser();
    $response = $this->get('/admin/attendees/' . $event->slug . '/registration-type/student');

    $response->assertStatus(200);
    $response->assertSee('Student - 3 Day Pass attendees of ' . $event->name);

    $response->assertSee($student->name);
    $link = url('/admin/attendees/'. $student->id);
    $response->assertSee('<a href="'.$link.'"');



  }

  private function createAndBeAdminUser(): User
  {
    $user = factory(User::class)->create();
    $user->setRole('admin');
    $user->hasPermissionOrFail('browse_admin');
    $this->be($user);
    return $user;
  }

  /**
   * @return Event
   */
  private function buildAnEvent(): Event
  {
    $event = factory(Event::class)->create([ 'active' => true, ]);
    return $event;
  }

  /**
   * @param $event
   * @return Attendee
   */
  private function buildAStudent($event): Attendee
  {
    return factory(Attendee::class)->create([ 'event_id' => $event->id, 'modifiers' => [
        'payment' => [

            'student' => [
                'value' => 12500,
                'description' => 'Student - 3 Day Pass',
            ],
        ],
    ]
    ]);
  }
}
