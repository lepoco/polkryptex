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

    private const CONTROLLER_NAMESPACE = 'Polkryptex\\Common\\Controllers\\';

    private const REQUEST_NAMESPACE = 'Polkryptex\\Common\\Requests\\';

    private array $routes = [];

    public static function init(array $routes = [])
    {
        return new self($routes);
    }

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
        $this->router = new \Bramus\Router\Router();

        $this->registerBaseRoutes();
    }

    public function run(): void
    {
        $this->router->run();
    }

    public function register($path, $namespace): void
    {
        $this->router->get($path, fn () => $this->view($namespace));
    }

    private function registerBaseRoutes(): void
    {
        $this->router->post('/request', fn () => $this->request());
        $this->router->get('/request', fn () => $this->request());

        $this->router->set404(fn () => $this->view('NotFound'));

        foreach ($this->routes as $route) {
            if (is_array($route[1])) {
                foreach ($route[1] as $subroute) {
                    $this->router->get($route[0] . $subroute[0], fn () => $this->view($subroute[1]));
                }
            } else {
                $this->router->get($route[0], fn () => $this->view($route[1]));
            }
        }
    }

    private function view(string $namespace): object
    {
        $controller = self::CONTROLLER_NAMESPACE . $namespace;
        if (!class_exists($controller)) {
            return new \Polkryptex\Core\Controller($namespace);
        }

        return new $controller($namespace);
    }

    private function request(): object
    {
        $requestController = self::REQUEST_NAMESPACE . filter_var($_REQUEST['action'] ?? '__UNKNOWN', FILTER_SANITIZE_STRING, ['default' => '__UNKNOWN']);
        if (!isset($_REQUEST['action']) || !class_exists($requestController)) {
            return new \Polkryptex\Core\Request();
        }

        return new $requestController();
    }
}
