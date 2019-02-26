<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function var_dump;

class EventsRoutingTest extends TestCase
{

  /**
   * GET Requests
   */
  public function testItHasAnIndexRoute()
  {
    $response = $this->get('/');
    $response->assertStatus(200);
  }

  public function testItHasAGetEventIndexRoute()
  {
    $response = $this->get('/events');
    $response->assertStatus(200);
  }

  public function testItHasAGetIndividualEventRoute()
  {
    $stub = 'fest';
    $response = $this->get('/events/'. $stub);
    $dump = $response->content();
    $response->assertStatus(200);
    $this->assertTrue('event ' . $stub == $dump);

  }

  public function testItHasAGetEventRegisterRoute()
  {
    $stub = 'fest';
    $response = $this->get('/events/' . $stub . '/register');
    $response->assertStatus(200);
//    $this->assertTrue($response->content() == $stub);
  }

  public function testItHasAGetEventRegistrationSuccessfulRoute()
  {
    $stub = 'fest';
    $response = $this->get('/events/' . $stub . '/registered');
    $response->assertStatus(200);
    $this->assertTrue($response->content() == $stub);
  }


  /**
   * POSTS
   */

  public function testItHasAPostEventRegistrationRoute()
  {
    $stub = 'fest';
    $response = $this->post('/events/' . $stub . '/register');
//    $response->assertStatus()
    $this->assertTrue($response->getStatusCode() !== 404);
//    $this->assertTrue($response->content() == $stub);
  }


}
