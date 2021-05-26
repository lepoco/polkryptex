<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Bramus\Router\Router as BramusRouter;
use Polkryptex\Common\Views;

/**
 * @author Leszek P.
 */
final class Router
{
    private BramusRouter $router;

    public function __construct()
    {
        $this->router = new BramusRouter();
        $this->registerRoutes();
        $this->router->run();
    }

    private function registerRoutes(): void
    {
        $this->router->set404(function () {
            Views::display('404');
        });
        $this->router->get('/', function () {
            Views::display('Home');
        });
    }
}
