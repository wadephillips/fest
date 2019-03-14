<?php

namespace Tests\Unit;

use App\Event;
use App\Http\Controllers\EventRegisterController;
use function env;
use Hashids\Hashids;
use Illuminate\Support\Facades\App;
use function method_exists;
use ReflectionClass;
use function secure_url;
use stdClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function var_dump;

class PresenterRegistrationTest extends TestCase
{
  private $salt;
  private $code;
  private $event;
  private $hashids;

  protected function setUp()
  {
    parent::setUp();
    $this->event = Event::first();
    $this->salt = env('HASH_ID_SALT', 'make it rain');
    $this->hashids = new Hashids($this->salt, 8);
    $this->code = $this->hashids->encode($this->event->id);
  }


  public function testTheControllerHasAPrivatePresenterAttribute()
  {

    $this->assertClassHasAttribute('presenter', EventRegisterController::class);
  }

  public function testTheControllerHasAPresentersMethod()
  {
    $controller = new EventRegisterController();
    $this->assertTrue(method_exists($controller, 'showPresenter'));

  }

  public function testItHasAVerifyPresenterMethod()
  {
    $controller = new EventRegisterController();
    $this->assertTrue(method_exists($controller, 'verifyPresenter'));
  }

  public function testItChecksTheCodeToVerifyACorrectPresenterUrlAndSalt()
  {
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod(EventRegisterController::class, 'verifyPresenter');
    $result = $method->invokeArgs($controller, [$this->event->id, $this->code, $this->salt ]);
    $this->assertTrue($result === true);

  }

  public function testItChecksTheCodeToVerifyAnIncorrectPresenterUrlAndCorrectSalt()
  {
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod(EventRegisterController::class, 'verifyPresenter');
    $invalidCode = $this->hashids->encode(5);

    $result = $method->invokeArgs($controller, [$this->event->id, $invalidCode , $this->salt ]);
    $this->assertTrue($result === false);

  }

  public function testItChecksTheCodeToVerifyAPresenterUrlAndIncorrectSalt()
  {
    $controller = App::make(EventRegisterController::class);
    $method = $this->getPrivateMethod(EventRegisterController::class, 'verifyPresenter');
//    $invalidCode = $this->hashids->encode(5);

    $result = $method->invokeArgs($controller, [$this->event->id, $this->code, 'bad salt' ]);
    $this->assertTrue($result === false);

  }

  public function testEventModelsHaveAPresenterUrlAttributeWithAValidCode()
  {
    $event= $this->event;
    $url = $event->presenterUrl;
    $code = $this->hashids->encode($event->id);
    $this->assertTrue($url == secure_url('/events/' . $event->slug . '/presenter/' . $code));

  }

  public function testItHasAValidRouteCorespondingToThePresenterUrlAttribute()
  {
    $event= $this->event;
    $url = $event->presenterUrl;
    $code = $this->hashids->encode($event->id);
    $result = $this->get($url);
    $result->assertOk();
    $result->assertViewIs('event.register');
    $result->assertViewHasAll(['event','presenter']);
    $result->assertViewHas('presenter', true);
  }

  public function testTryingToAccessTheRouteWithAnMadeUpCodeTakesYouToTheMainRegistrationForm()
  {
    $event = $this->event;
//    $url = $event->presenterUrl;
//    $code = $this->hashids->encode($event->id);
    $userGeneratedCode = 'wywy5yc7';
    $badUrl = secure_url('/events/' . $event->slug . '/presenter/' . $userGeneratedCode);
    $result = $this->get($badUrl);
    $result->assertOk();
    $result->assertViewIs('event.register');
    $result->assertViewHasAll([ 'event', 'presenter' ]);
    $result->assertViewHas('presenter', false);

  }

  public function testTryingToAccessTheRouteWithAnInvalidCodeTakesYouToTheMainRegistrationForm()
  {
    $event= $this->event;
    $code = $this->hashids->encode($event->id + 1);
    $badUrl = secure_url('/events/' . $event->slug . '/presenter/' . $code);
    $result = $this->get($badUrl);
    $result->assertOk();
    $result->assertViewIs('event.register');
    $result->assertViewHasAll(['event','presenter']);
    $result->assertViewHas('presenter', false);

  }


}
