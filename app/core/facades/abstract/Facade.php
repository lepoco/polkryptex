<?php

namespace App\Core\Facades\Abstract;

use App\Core\Bootstrap;

/**
 * Creates a static link to an existing application instance and its properties.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
abstract class Facade
{
  // TODO: We should measure the memory load by this singleton.
  protected static object $app;

  abstract protected static function getFacadeAccessor(): string;

  /**
   * Responds to a static call to the Facade class and then tries to execute a method with the same name on the application object.
   * @param mixed|array $arguments
   * @return mixed
   */
  public static function __callStatic(string $name, $arguments)
  {
    $instance = self::getProperty(static::getFacadeAccessor());

    if (false === $instance) {
      return false;
    }

    return $instance->{$name}(...$arguments);
  }

  /**
   * Defines a global reference to an application instance.
   */
  final public static function setApp(Bootstrap &$app): void
  {
    // TODO: Passing by a pointer in PHP creates copies, we should test the performance of this solution.
    static::$app = $app;
  }

  /**
   * Gets the application instance from the global reference.
   */
  final public static function app(): Bootstrap
  {
    if (!isset(static::$app)) {
      return null;
    }

    return static::$app;
  }

  /**
   * Gets an application object that is an instance of one of the logic elements.
   */
  final public static function getProperty(string $property): ?object
  {
    // TODO: TEST
    // WARNING: Generates about a hundred returns

    // ray([
    //   'app_called' => time(),
    //   'memory' => memory_get_usage(),
    //   'app' => spl_object_hash((isset(static::$app) ? static::$app : new \stdClass()))
    // ]);

    if (!isset(static::$app)) {
      return null;
    }

    return static::$app->getProperty($property);
  }
}
