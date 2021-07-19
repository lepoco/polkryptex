<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use App\Core\Registry;

/**
 * @author Leszek P.
 */
abstract class Router
{
  protected \Bramus\Router\Router $router;

  protected \Nette\Http\Request $request;

  protected \Nette\Http\Response $response;

  protected array $routes = [];

  public function __construct(\Nette\Http\Request $request, \Nette\Http\Response $response, array $routes = [])
  {
    $this->request = $request;
    $this->response = $response;

    $this->routes = $routes;
    $this->router = new \Bramus\Router\Router();

    if (!defined('APP_VERSION')) {
      $this->register('', 'Installer', ['title' => 'Installer', 'fullscreen' => true]);
      $this->run();

      return;
    }

    if (Debug::isDebug()) {
      $this->register('/debug', 'Debug');
    }

    $this->registerBaseRoutes();

    if (method_exists($this, 'initialize')) {
      $this->{'initialize'}();
    }

    $this->run();
  }

  public function run(): void
  {
    $this->router->run();
  }

  public function register(string $path, string $namespace, array $arguments = []): void
  {
    $this->router->get($path, fn () => $this->handleView($namespace, $arguments));
  }

  private function registerBaseRoutes(): void
  {
    $this->router->post('/request', fn () => $this->handleRequest());
    $this->router->get('/request', fn () => $this->handleRequest());

    $this->router->get('/signout', function () {

      if (Registry::get('Account')->isLoggedIn()) {

        Registry::get('Debug')->info('User has logged out', ['user' => Registry::get('Account')->currentUser()->getEmail()]);
        Registry::get('Account')->signOut();
      }

      $baseUrl = Registry::get('Options')->get('baseurl', null);

      if (null === $baseUrl) {
        $baseUrl = ($this->request->isSecured() ? 'https://' : 'http://') . $this->request->url->host . '/';
      }

      $this->response->redirect($baseUrl);
    });

    $this->router->set404(fn () => $this->handleView('NotFound', ['title' => 'Page not found', 'fullscreen' => true]));

    foreach ($this->routes as $route) {

      if (!isset($route[2])) {
        $route = [];
      }

      if (is_array($route[1])) {
        foreach ($route[1] as $subroute) {
          $this->router->get($route[0] . $subroute[0], fn () => $this->handleView($subroute[1], $route[2]));
        }
      } else {
        $this->router->get($route[0], fn () => $this->handleView($route[1], $route[2]));
      }
    }
  }

  private function handleView(string $namespace, array $arguments = []): object
  {
    return new \App\Core\Controller($this->response, $this->request, $namespace, $arguments);
  }

  private function handleRequest(): object
  {
    $requestController = Application::REQUEST_NAMESPACE . filter_var($_REQUEST['action'] ?? '__UNKNOWN', FILTER_SANITIZE_STRING, ['default' => '__UNKNOWN']) . 'Request';
    if (!isset($_REQUEST['action']) || !class_exists($requestController)) {
      return new \App\Core\Request($this->response, $this->request);
    }

    return new $requestController($this->response, $this->request);
  }
}
