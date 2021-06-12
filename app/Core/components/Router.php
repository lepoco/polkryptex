<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

/**
 * @author Leszek P.
 */
final class Router
{
    private \Bramus\Router\Router $router;

    public static function init()
    {
        return new self();
    }

    public function __construct()
    {
        $this->router = new \Bramus\Router\Router();
        $this->registerRoutes();
        $this->router->run();
    }

    private function registerRoutes(): void
    {
        // if(!defined(''))
        // {
        //     $this->router->get('/', function () {
        //         Views::display('Installer');
        //     });
        //     return;
        // }

        $this->router->get('/request', function () {
            new \Polkryptex\Core\Request();
        });

        $this->router->set404(function () {
            Views::display('NotFound');
        });

        $this->router->get('/signin', function () {
            Views::display('SignIn');
        });
        
        $this->router->get('/', function () {
            Views::display('Home');
        });

        $this->router->get('/help', function () {
            Views::display('Help');
        });

        $this->router->get('/dashboard', function () {
            Views::display('Dashboard\\Dashboard');
        });
    }
}
