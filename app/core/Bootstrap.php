<?php

namespace App\Core;

use App\Core\Http\{Router, Response, Session};
use App\Core\Data\Options;
use App\Core\Facades\App;
use App\Core\Data\Container;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Cache\CacheManager;
use Illuminate\Log\LogManager;

/**
 * Creates all connections and application objects.
 * Should be an abstraction to the App class.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
abstract class Bootstrap implements \App\Core\Schema\App
{
  protected int $status;

  protected bool $connected;

  protected Container $container;

  protected Router $router;

  protected Repository $configuration;

  protected Request $request;

  protected Response $response;

  protected Session $session;

  protected CacheManager $cache;

  protected LogManager $logs;

  protected Manager $database;

  protected Options $options;

  protected FileSystem $filesystem;

  abstract public function init(): void;

  /**
   * Application specific constructor. Creates instances of base objects and assigns them to Facades.
   */
  public function setup(): self
  {
    $this->status = 0;

    $this->init();
    $this->setupContainer();

    App::set($this);

    return $this;
  }

  /**
   * Attempts to connect to the database and creates the Database, Options, and Cache objects.
   */
  public function connect(): self
  {
    $this
      ->setDatabase(new Manager($this->container))
      ->setCache(new CacheManager($this->container))
      ->setOptions(new Options())
      ->setSession(new Session());

    $this->isConnected(true);

    $timeNow = time();

    if ($this->isConnected() && $this->session->has('last_opened')) {
      $maxDiff = (int) $this->options->get('signout_time', 15);
      $maxDiff = $maxDiff < 1 ? 60 : $maxDiff * 60;

      if (($timeNow - $this->session->get('last_opened')) > $maxDiff) {
        $this->destroy();
      }
    }

    $this->session->put('last_opened', $timeNow);

    return $this;
  }

  /**
   * Triggers Router and tries to create the view to display or execute the Request.
   */
  public function print(): self
  {
    $this
      ->router
      ->setup()
      ->run();

    $this->close();

    return $this;
  }

  /**
   * Closes session and triggers the Garbage Collector.
   */
  public function close(bool $exit = true): void
  {
    $this->session->put('_rendered', time());

    $this->session->save();

    $this->response->send();

    if ($exit) {
      exit($this->status);
    }
  }

  /**
   * Flush the session data and regenerate the ID.
   */
  public function destroy(): void
  {
    $this->session->clear();
    $this->session->invalidate();
  }

  /**
   * Generate a new session identifier and token.
   */
  public function regenerate(): void
  {
    $this->session->regenerate();
  }

  /**
   * Gets an application object that is an instance of one of the logic elements.
   * @return mixed
   */
  final public function getProperty(string $property): object
  {
    $objects = get_object_vars($this);

    if (!isset($objects[$property])) {
      return $this;
    }

    return $objects[$property];
  }

  /**
   * Checks whether the database is connected.
   */
  final public function isConnected(bool $forceReCheck = false): bool
  {
    if (!$forceReCheck && isset($this->connected)) {
      return $this->connected;
    }

    $this->connected = false;

    try {
      if (!isset($this->database)) {
        return false;
      }

      $pdo = $this->database->connection()->getPdo();

      if ($pdo) {
        $this->connected = true;
      }
    } catch (\Throwable $th) {
      if (isset($this->logs)) {
        $this->logs->critical('Connection to the database failed.', ['error' => $th]);
      }
    }

    return $this->connected;
  }

  /**
   * Reassign the objects to the controller.
   */
  final public function rebind(string $abstract = ''): bool
  {
    if (empty($abstract) || 'config' === $abstract) {
      $this->container->bind('config', fn () => $this->configuration, true);
    }

    if (empty($abstract) || 'files' === $abstract) {
      $this->container->bind('files', fn () => $this->filesystem, true);
    }

    if (empty($abstract) || 'events' === $abstract) {
      $this->container->bind('events', fn () => new Dispatcher(), true);
    }

    if (empty($abstract) || 'logs' === $abstract) {
      $this->setLogs(new LogManager($this->container));
    }

    return true;
  }

  final protected function setupContainer(): self
  {
    $this->request = Request::capture();
    $this->response = new Response('', 200, $this->request->headers->all());

    $this->filesystem = new Filesystem();
    $this->container = new Container();

    $this->generateDirectories();
    $this->rebind();

    \Illuminate\Support\Facades\Facade::setFacadeApplication($this->container);

    return $this;
  }

  final protected function setLogs(LogManager $logManager): self
  {
    $this->logs = $logManager;

    return $this;
  }

  protected function setSession(Session $session): self
  {
    $this->session = $session;

    $this->session->start();

    return $this;
  }

  protected function setRouter(Router $router): self
  {
    $this->router = $router;

    return $this;
  }

  protected function setConfig(Repository $configuration): self
  {
    $this->configuration = $configuration;

    return $this;
  }

  protected function setDatabase(Manager $database): self
  {
    $this->database = $database;

    $this->database->setAsGlobal();
    $this->database->bootEloquent();

    return $this;
  }

  protected function setOptions(Options $options): self
  {
    $this->options = $options;

    return $this;
  }

  protected function setCache(CacheManager $cache): self
  {
    // FIXME:: Cache needs garbage collector.
    $this->cache = $cache;

    return $this;
  }

  protected function generateDirectories(): void
  {
    if (!$this->filesystem->isDirectory($this->configuration->get('view.compiled', 'storage/blade'))) {
      $this->filesystem->makeDirectory($this->configuration->get('view.compiled', 'storage/blade'), 0755, true);
    }

    if (!$this->filesystem->isDirectory($this->configuration->get('storage.logs', 'storage/logs'))) {
      $this->filesystem->makeDirectory($this->configuration->get('storage.logs', 'storage/logs'), 0755, true);
    }

    if (!$this->filesystem->isDirectory($this->configuration->get('cache.stores.file.path', 'storage/cache'))) {
      $this->filesystem->makeDirectory($this->configuration->get('cache.stores.file.path', 'storage/cache'), 0755, true);
    }
  }
}
