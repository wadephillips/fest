<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PermissionRoleTableSeeder;
use PermissionsTableSeeder;
use RolesTableSeeder;

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


    $response = $this->get('/admin/attendees/fest/registration-type/student');

    //todo: resume select the appropriate attendees for the event and who have the appropriate registrations.  Write a test.

    $response->assertStatus(200);
//    $response->assertSee('Dashboard');

  }

  private function createAndBeAdminUser(): User
  {
    $user = factory(User::class)->create();
    $user->setRole('admin');
    $user->hasPermissionOrFail('browse_admin');
    $this->be($user);
    return $user;
  }
}
