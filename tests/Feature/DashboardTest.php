<?php

namespace Tests\Feature;

use App\Attendee;
use App\Event;
use App\User;
use function collect;
use function dd;
use function factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PermissionRoleTableSeeder;
use PermissionsTableSeeder;
use function print_r;
use RolesTableSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
  use DatabaseMigrations;

  protected function setUp()
  {
    parent::setUp();
    $this->seed(RolesTableSeeder::class);
    $this->seed(PermissionsTableSeeder::class);
    $this->seed(PermissionRoleTableSeeder::class);
  }

  public function testAnUnauthorizedUserShouldNotBeAbleToSeeTheDashboard()
  {
    $this->withoutExceptionHandling();

    $response = $this->get('/admin/');

    $response->assertStatus(302)
        ->assertSee('Redirecting to ' . url('admin/login'));


  }


  public function testAnAuthorizedUserCanSeeTheDashBoard()
  {
    $this->withoutExceptionHandling();


    $user = $this->createAndBeAdminUser();


    $response = $this->get('/admin');

    $response->assertStatus(200);
    $response->assertSee('Dashboard');

  }

  public function testAUserSeesASetOfStatisticsForEachActiveEvent()
  {
//    $this->withoutExceptionHandling();

    $user = $this->createAndBeAdminUser();

    $events = factory(Event::class, 2)
        ->create()
        ->each(function ($event) {
          factory(Attendee::class, 10)->create([ 'event_id' => $event->id ]);
        });

    $inactive = factory(Event::class)->create([ 'active' => false ]);


    $response = $this->get('/admin');
    $response->assertStatus(200);
    $response->assertSee($events[ 0 ]->name);
    $response->assertSee($events[ 1 ]->name);
    $response->assertDontSee($inactive->name);

  }


  public function testEachActiveEventHasATableDisplayingAttendeeTypeTotals()
  {

    //given we have an admin and an event with attendees
    $this->createAndBeAdminUser();
    $event = factory(Event::class)->create([ 'active' => true,]);
    $attendees = $this->createAttendees($event);

    //an the view should receive aggregate data with counts of registration types
    $response = $this->get('/admin');

    $response->assertSee($event->name);
    $response->assertSee('Additional Family Member / Significant Other - Adult');
    $response->assertSee('Student - 3 Day Pass');

  }

  //todo resume: all the names in the above table should be links to /admin/attendees/{event-id}/registration-type/{registration_type}

  private function createAndBeAdminUser(): User
  {
    $user = factory(User::class)->create();
    $user->setRole('admin');
    $user->hasPermissionOrFail('browse_admin');
    $this->be($user);
    return $user;
  }

  private function createAttendees(Event $event)
  {
    $attendees = collect();
    $three_day_attendees = factory(Attendee::class, 3)->create([
        'event_id' => $event->id,
        'modifiers' => [
            'payment' => [
                'linens' => [
                    'value' => 1500,
                    'description' => 'Linens: Yes',
                ],
                'three_day_overnight_pass' => [
                    'value' => 30000,
                    'description' => 'Three Day Pass - Overnight Stay',
                ],
            ],
            'meal' => [
                'type' => [
                    [
                        'description' => 'Omnivore',
                    ]
                ],
            ],
        ],
        'total' => 31500,
    ]);

    $ear_attendees = factory(Attendee::class, 2)->create([
        'event_id' => $event->id,
        'modifiers' => [
            'payment' => [
                'ear_training_day_only' => [
                    'value' => 25000,
                    'description' => 'Ear Training - 3 Day Pass - No Overnight Stay',
                ],

                'poca_tech_donation' => [
                    'value' => 500,
                    'description' => 'Donate $5 to POCA Tech',
                ],
            ],
            'meal' => [
                'type' => [
                    [
                        'description' => 'Vegetarian',
                    ]
                ],
            ],
            'other' => [
                'other' => [
                    'value' => 'Teach me lots!',
                    'description' => 'Teach me lots!',
                ],
            ],
        ],
        'total' => 25500,
    ]);

    $students = factory(Attendee::class, 4)->create([
        'event_id' => $event->id,
        'modifiers' => [
            'payment' => [
                'linens' => [
                    'value' => 1500,
                    'description' => 'Linens: Yes',
                ],
                'student' => [
                    'value' => 12500,
                    'description' => 'Student - 3 Day Pass',
                ],
            ],
            'meal' => [
                'type' => [
                    [
                        'description' => 'Vegan',
                    ]
                ],
                'other_food' => [
                    'description' => 'No meats!!',
                ],
            ],
        ],
        'total' => 31500,
    ]);

    $fso_attendee = factory(Attendee::class)->create([
        'event_id' => $event->id,
        'modifiers' => [
            'payment' => [
                'linens' => [
                    'value' => 0,
                    'description' => 'Linens: No',
                ],
                'fso_adult' => [
                    'value' => 10000,
                    'description' => 'Additional Family Member / Significant Other - Adult',
                ],
                'poca_tech_donation' => [
                    'value' => 500,
                    'description' => 'Donate $5 to POCA Tech',
                ],
            ],
            'meal' => [
                'type' => [
                    [
                        'description' => 'Omnivore',
                    ]
                ],
            ],
        ],
        'total' => 10500,
    ]);

    $attendees->merge($three_day_attendees);
    $attendees->merge($students);
    $attendees->merge($ear_attendees);
    $attendees->merge($fso_attendee);
    return $attendees;
  }


}
