<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

use App\Core\Registry;
use Nette\Http\Response;

/**
 * @author Leszek P.
 */
final class Router
{
    private const REQUEST_NAMESPACE = 'App\\Common\\Requests\\';

    private \Bramus\Router\Router $router;

    private array $routes = [];

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

    public function register(string $path, string $namespace, array $arguments = []): void
    {
        $this->router->get($path, fn () => $this->view($namespace, $arguments));
    }

    private function registerBaseRoutes(): void
    {
        $this->router->post('/request', fn () => $this->request());
        $this->router->get('/request', fn () => $this->request());

        $this->router->get('/signout', function () {

            if (Registry::get('Account')->isLoggedIn()) {
                Registry::get('Account')->signOut();
            }

            $baseUrl = Registry::get('Options')->get('baseurl', (Registry::get('Request')->isSecured() ? 'https://' : 'http://') . Registry::get('Request')->url->host . '/');
            Registry::get('Response')->redirect($baseUrl);
        });

        $this->router->set404(fn () => $this->view('NotFound', ['title' => 'Page not found', 'fullscreen' => true]));

        foreach ($this->routes as $route) {

            if (!isset($route[2])) {
                $route = [];
            }

            if (is_array($route[1])) {
                foreach ($route[1] as $subroute) {
                    $this->router->get($route[0] . $subroute[0], fn () => $this->view($subroute[1], $route[2]));
                }
            } else {
                $this->router->get($route[0], fn () => $this->view($route[1], $route[2]));
            }
        }
    }

    private function view(string $namespace, array $arguments = []): object
    {
        return new \App\Core\Controller($namespace, $arguments);
    }

    private function request(): object
    {
        $requestController = self::REQUEST_NAMESPACE . filter_var($_REQUEST['action'] ?? '__UNKNOWN', FILTER_SANITIZE_STRING, ['default' => '__UNKNOWN']) . 'Request';
        if (!isset($_REQUEST['action']) || !class_exists($requestController)) {
            return new \App\Core\Request();
        }

        return new $requestController();
    }
}
