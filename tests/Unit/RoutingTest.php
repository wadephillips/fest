<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function var_dump;

class RoutingTest extends TestCase
{

  public function testItHasAnIndexRoute()
  {
    $response = $this->get('/');
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

  public function testItHasAGetEventIndexRoute()
  {
    $response = $this->get('/events');
    $response->assertStatus(200);
  }
}
