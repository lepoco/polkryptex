<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

/**
 * @author Leszek P.
 */
final class Application
{
    /**
     * @link https://packagist.org/packages/monolog/monolog
     * @link https://github.com/bramus/router
     */
    private function __construct()
    {
        Registry::register('Debug', new Debug());
        Registry::register('Database', new Database(), ['\Polkryptex\Core\Components\Queries']);
        Registry::register('Options', new Components\Options(), ['\Polkryptex\Core\Controller', '\Polkryptex\Core\Request']);
        Registry::register('Response', new \Nette\Http\Response());
        Registry::register('Request', (new \Nette\Http\RequestFactory())->fromGlobals());
        Registry::register('Account', new Components\Account());

        $this->registerSession();
        $this->registerTranslation();
        $this->registerRouter();
    }

    private function registerSession()
    {
        Registry::register('Session', new \Nette\Http\Session(Registry::get('Request'), Registry::get('Response')));
        Registry::get('Session')->start();
    }

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

    private function registerRouter()
    {
        $router = new Components\Router();

        if(!defined('APP_VERSION')) {
            $router->register('', 'Installer', ['title' => 'Installer', 'fullscreen' => true]);
            $router->run();

            return;
        }

        if(Debug::isDebug()) {
            $router->register('/debug', 'Debug');
        }

        $router->register('', 'Home', ['title' => 'Home']);
        $router->register('/register', 'Register', ['title' => 'Register', 'fullscreen' => true]);
        $router->register('/signin', 'SignIn', ['title' => 'Sign In', 'fullscreen' => true]);
        $router->register('/plans', 'Plans', ['title' => 'Plans']);
        $router->register('/help', 'Help', ['title' => 'Help']);
    
        $router->register('/dashboard', 'Dashboard\\Dashboard', ['title' => 'Dashboard', 'requireLogin' => true]);
        $router->register('/dashboard/wallet', 'Dashboard\\Wallet', ['title' => 'Wallet', 'requireLogin' => true]);

        $router->run();
    }

    /**
     * Returns a new application instance, should be triggered by public/index.php
     * @return Application
     */
    static function start(): self
    {
        return new self();
    }

    static function stop(?string $message = null): void
    {
        Registry::get('Session')->close();
        exit($message);
    }
}
