<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

/**
 * @author Leszek P.
 */
abstract class Application
{
  public const APP_NAME = 'App';

  public const APP_VERSION = '1.0.0';

  public const REQUEST_NAMESPACE = 'App\\Common\\Requests\\';

  public function __construct()
  {
    /** @var \Nette\Http\Response */
    $response = new \Nette\Http\Response();
    /** @var \Nette\Http\Request */
    $request = (new \Nette\Http\RequestFactory())->fromGlobals();
    /** @var \Nette\Http\Session */
    $session = new \Nette\Http\Session($request, $response);

    Registry::register('Debug', new Debug($request));
    Registry::register('Database', new Database(), ['\App\Core\Components\Queries']);
    Registry::register('Options', new Components\Options(), ['\App\Core\Controller', '\App\Core\Request']);
    Registry::register('Account', new Components\Account($request, $response));
    /**
     * @see https://doc.nette.org/en/3.1/sessions
     */
    Registry::register('Session', new \Nette\Http\Session($request, $response));
    self::Session()->start();

    $this->registerExceptions();
    $this->registerTranslation();

    /**
     * @see https://github.com/bramus/router
     */
    (new \App\Common\Routes($request, $response));
  }

  public static function Debug(): Debug
  {
    return Registry::get('Debug');
  }

  public static function Database(): Database
  {
    return Registry::get('Database');
  }

  public static function Account(): Components\Account
  {
    return Registry::get('Account');
  }

  public static function Session(): \Nette\Http\Session
  {
    return Registry::get('Session');
  }

  public static function getOption(string $name, $default = null)
  {
    return Registry::get('Options')->get($name, $default);
  }

  public static function getUrl(?string $path = null): string
  {
    return Registry::get('Options')->get('baseurl', strtok(sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
      $_SERVER['SERVER_NAME'],
      $_SERVER['REQUEST_URI']
    ), '?')) . $path;
  }

  public static function translate(string $text, ?array $variables = null): ?string
  {
    return Registry::get('Translator')->translate($text, $variables);
  }

  private function registerExceptions(): void
  {
    //set_error_handler([Registry::get('Debug'), 'errorHandler']);
    //set_exception_handler([Registry::get('Debug'), 'exceptionHandler']);
  }

  /**
   * @see https://symfony.com/doc/current/translation.html
   */
  private function registerTranslation()
  {
    $translator = new Components\Translator();

    switch (self::getOption('language', 'en')) {
      case 'pl':
        $translator->setLanguage('pl_PL');
        break;
      default:
        $translator->setLanguage('en_US');
        break;
    }

    Registry::register('Translator', $translator);
  }

  /**
   * Exits the application and closes the session. Optionally, it can display the given string.
   * @param null|string $message Optional message to display
   */
  static function stop(?string $message = null): void
  {
    self::Debug()->close();
    self::Session()->close();
    exit($message);
  }
}
