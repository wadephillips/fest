<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

  public function getPrivateMethod($className, $methodName)
  {
    $reflector = new ReflectionClass($className);
    $method = $reflector->getMethod($methodName);
    $method->setAccessible(true);

    return $method;
  }
}
