<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core\Components;

use Bramus\Router\Router as BramusRouter;

/**
 * @author Leszek P.
 */
final class Router
{
    private BramusRouter $router;

    public static function init()
    {
        return new self();
    }

    public function __construct()
    {
        $this->router = new BramusRouter();
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
    }
}
