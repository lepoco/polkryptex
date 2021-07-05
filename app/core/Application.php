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
    private function __construct()
    {
        Registry::register('Debug', new Debug());
        Registry::register('Database', new Database(), ['\App\Core\Components\Queries']);
        Registry::register('Options', new Components\Options(), ['\App\Core\Controller', '\App\Core\Request']);
        Registry::register('Response', new \Nette\Http\Response());
        Registry::register('Request', (new \Nette\Http\RequestFactory())->fromGlobals());
        Registry::register('Account', new Components\Account());

        $this->registerExceptions();
        $this->registerSession();
        $this->registerTranslation();
        $this->registerRouter();
    }

    private function registerExceptions(): void
    {
        //set_error_handler([Registry::get('Debug'), 'errorHandler']);
        //set_exception_handler([Registry::get('Debug'), 'exceptionHandler']);
    }

    /**
     * @see https://doc.nette.org/en/3.1/sessions
     */
    private function registerSession()
    {
        Registry::register('Session', new \Nette\Http\Session(Registry::get('Request'), Registry::get('Response')));
        Registry::get('Session')->start();
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
     * @see https://github.com/bramus/router
     */
    private function registerRouter()
    {
        $router = new Components\Router();

        if (!defined('APP_VERSION')) {
            $router->register('', 'Installer', ['title' => 'Installer', 'fullscreen' => true]);
            $router->run();

            return;
        }

        if (Debug::isDebug()) {
            $router->register('/debug', 'Debug');
        }

        $router->register('', 'Home', ['title' => 'Home']);
        $router->register('/register', 'Register', ['title' => 'Register', 'fullscreen' => true]);
        $router->register('/signin', 'SignIn', ['title' => 'Sign In', 'fullscreen' => true]);
        $router->register('/plans', 'Plans', ['title' => 'Plans']);
        $router->register('/help', 'Help', ['title' => 'Help']);

        $router->register('/dashboard', 'Dashboard\\Dashboard', ['title' => 'Dashboard', 'requireLogin' => true]);
        $router->register('/dashboard/wallet', 'Dashboard\\Wallet', ['title' => 'Wallet', 'requireLogin' => true]);
        $router->register('/dashboard/wallet/transfer', 'Dashboard\\WalletTransfer', ['title' => 'Transfer', 'requireLogin' => true]);
        $router->register('/dashboard/wallet/exchange', 'Dashboard\\WalletExchange', ['title' => 'Exchange', 'requireLogin' => true]);
        $router->register('/dashboard/wallet/topup', 'Dashboard\\WalletTopup', ['title' => 'Top Up', 'requireLogin' => true]);
        $router->register('/dashboard/account', 'Dashboard\\Account', ['title' => 'Account', 'requireLogin' => true]);
        $router->register('/dashboard/account/change-password', 'Dashboard\\AccountNewPassword', ['title' => 'Change your password', 'requireLogin' => true]);

        $router->register('/admin', 'Admin\\Admin', ['title' => 'Admin Dashboard', 'requireLogin' => true, 'permissions' => ['all']]);
        $router->register('/admin/users', 'Admin\\AdminUsers', ['title' => 'Admin Users', 'requireLogin' => true, 'permissions' => ['all']]);
        $router->register('/admin/configuration', 'Admin\\AdminConfiguration', ['title' => 'Admin Configuration', 'requireLogin' => true, 'permissions' => ['all']]);
        $router->register('/admin/tools', 'Admin\\AdminTools', ['title' => 'Admin Tools', 'requireLogin' => true, 'permissions' => ['all']]);
        
        $router->register('/private', 'Static\\Private', ['title' => 'Private']);
        $router->register('/business', 'Static\\Business', ['title' => 'Business']);
        $router->register('/licenses', 'Static\\Licenses', ['title' => 'Licenses']);

        $router->run();
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
