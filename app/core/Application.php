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
final class Application
{
  public const APP_NAME = 'Polkryptex';

  public const REQUEST_NAMESPACE = 'App\\Common\\Requests\\';

  private function __construct()
  {
    $response = new \Nette\Http\Response();
    $request = (new \Nette\Http\RequestFactory())->fromGlobals();

    Registry::register('Debug', new Debug($request));
    Registry::register('Database', new Database(), ['\App\Core\Components\Queries']);
    Registry::register('Options', new Components\Options(), ['\App\Core\Controller', '\App\Core\Request']);
    Registry::register('Account', new Components\Account($request, $response));

    $this->registerExceptions();
    $this->registerTranslation();

    /**
     * @see https://doc.nette.org/en/3.1/sessions
     */
    Registry::register('Session', new \Nette\Http\Session($request, $response));
    Registry::get('Session')->start();

    /**
     * @see https://github.com/bramus/router
     */
    (new \App\Common\Routes($request, $response));
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
   * Returns a new application instance, should be triggered by public/index.php
   */
  static function start(): self
  {
    return new self();
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
