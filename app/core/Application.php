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

  public const REQUEST_NAMESPACE = 'App\\Common\\Requests\\';

  public function __construct()
  {
    $response = new \Nette\Http\Response();
    $request = (new \Nette\Http\RequestFactory())->fromGlobals();

    Registry::register('Debug', new Debug($request));
    Registry::register('Database', new Database(), ['\App\Core\Components\Queries']);
    Registry::register('Options', new Components\Options(), ['\App\Core\Controller', '\App\Core\Request']);
    Registry::register('Account', new Components\Account($request, $response));
    /**
     * @see https://doc.nette.org/en/3.1/sessions
     */
    Registry::register('Session', new \Nette\Http\Session($request, $response));
    Registry::get('Session')->start();

    $this->registerExceptions();
    $this->registerTranslation();

    /**
     * @see https://github.com/bramus/router
     */
    (new \App\Common\Routes($request, $response));
  }

  public static function getOption(string $name, $default = null): string
  {
    return Registry::get('Options')->get($name, $default);
  }

  public static function getUrl(?string $path = null): string
  {
    return Registry::get('Options')->get('baseurl', (Registry::get('Request')->isSecured() ? 'https://' : 'http://') . Registry::get('Request')->url->host . '/') . $path;
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

    switch (Registry::get('Options')->get('language', 'en')) {
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
    Registry::get('Debug')->close();
    Registry::get('Session')->close();
    exit($message);
  }
}
