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

    private array $routes = [];

    public static function init(array $routes = [])
    {
        return new self($routes);
    }

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
        $this->router = new \Bramus\Router\Router();

        $this->registerRoutes();
        $this->router->run();
    }

    private function registerRoutes(): void
    {
        $this->router->get('/request', fn () => new \Polkryptex\Core\Request());
        $this->router->set404(fn () => Views::display('NotFound'));

        foreach ($this->routes as $route) {
            if (is_array($route[1])) {
                foreach ($route[1] as $subroute) {
                    $this->router->get($route[0] . $subroute[0], fn () => Views::display($subroute[1]));
                }
            } else {
                $this->router->get($route[0], fn () => Views::display($route[1]));
            }
        }
    }
}
