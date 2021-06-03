<?php

namespace Tests\Feature;

use App\Attendee;
use App\Event;
use App\User;
use function array_key_exists;
use function collect;
use function dd;
use function factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PermissionRoleTableSeeder;
use PermissionsTableSeeder;
use function print_r;
use RolesTableSeeder;
use Tests\TestCase;
use function var_dump;

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
        ->assertSee('Redirecting to '.url('admin/login'));
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
            factory(Attendee::class, 10)->create(['event_id' => $event->id]);
        });

        $inactive = factory(Event::class)->create(['active' => false]);

        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertSee($events[0]->name);
        $response->assertSee($events[1]->name);
        $response->assertDontSee($inactive->name);
    }

    public function testEachActiveEventHasATableDisplayingAttendeeTypeTotals()
    {

    //given we have an admin and an event with attendees
        $this->createAndBeAdminUser();
        $event = factory(Event::class)->create(['active' => true]);
        $attendees = $this->createAttendees($event);

        //an the view should receive aggregate data with counts of registration types
        $response = $this->get('/admin');

        $response->assertSee($event->name);
        $response->assertSee('Additional Family Member / Significant Other - Adult');
        $response->assertSee('Student - 3 Day Pass');
    }

    public function testItDisplaysACountOfAttendeesWhoDonated()
    {
        //    $this->withoutExceptionHandling();

        //given we're on the dashboard
        $this->createAndBeAdminUser();
        $event = factory(Event::class)->create(['active' => true]);
        // and we have Attendees who donated
        $attendees = $this->createAttendees($event);
        $response = $this->get('/admin');
        // we should see a count of donors

        $response->assertSee('Donors');
        $response->assertSee(' Donate $5 to POCA Tech');
        $response->assertSee('<span class="badge badge-warning" id="poca-tech-donor-count">4</span>');
    }

    public function testItDisplaysACountOfLinensRequested()
    {
        //given we're on the dashboard
        $this->createAndBeAdminUser();
        $event = factory(Event::class)->create(['active' => true]);
        // and we have Attendees who donated
        $attendees = $this->createAttendees($event);
        $response = $this->get('/admin');
        //we should see a count of people who want linens
        $response->assertSee('Linens');
        $response->assertSee(' Linens: Yes');
        $response->assertSee('<span class="badge badge-warning linens-count-badge">7</span>');
    }

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
        $attendees = factory(Attendee::class, 3)->create([
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

                        'description' => 'Omnivore',

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

                        'description' => 'Vegetarian',

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
                        'description' => 'Vegan',
                    ],
                'other_food' => [
                    'description' => 'No meats!!',
                ],
            ],
        ],
        'total' => 31500,
    ]);

        $fso_attendee = factory(Attendee::class, 2)->create([
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
                        'description' => 'Omnivore',
                    ],
            ],
        ],
        'total' => 10500,
    ]);

//    $attendees->merge($three_day_attendees);
        $attendees->merge($students);
        $attendees->merge($ear_attendees);
        $attendees->merge($fso_attendee);

        return $attendees;
    }
}
