<?php

namespace App\Core;

use App\Core\Http\Router;
use App\Core\Data\Options;
use App\Core\Facades\App;
use App\Core\Data\Container;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Cookie\CookieJar;
use Illuminate\Cache\CacheManager;
use Illuminate\Log\LogManager;
use Illuminate\Session\SessionManager;

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

  protected SessionManager $session;

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
    $this->init();

    $this
      ->setStatus(0)
      ->setRequest(Request::capture())
      ->setFilesystem(new Filesystem())
      ->setContainer(new Container());

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
      ->setOptions(new Options());

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

    return $this;
  }

  /**
   * Closes session and triggers the Garbage Collector.
   */
  public function close(): void
  {
    $this->session->save();

    exit($this->status);
  }

  /**
   * Gets an application object that is an instance of one of the logic elements.
   * @return mixed
   */
  public function getProperty(string $property): object
  {
    $objects = get_object_vars($this);

    if (!isset($objects[$property])) {
      return $this;
    }

    return $objects[$property];
  }

  /**
   * Reassign the objects to the controller.
   */
  public function rebind(string $abstract = ''): bool
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

    if (empty($abstract) || 'cookie' === $abstract) {
      $this->container->bind('cookie', fn () => (new CookieJar())->setDefaultPathAndDomain(
        $this->configuration->get('session.path'),
        $this->configuration->get('session.domain'),
        $this->configuration->get('session.secure'),
        $this->configuration->get('session.same_site')
      ), true);
    }

    if (empty($abstract) || 'session' === $abstract) {
      $this->setSession(new SessionManager($this->container));
    }

    if (empty($abstract) || 'logs' === $abstract) {
      $this->setLogs(new LogManager($this->container));
    }

    return $this->isConnected(true);
  }

  /**
   * Checks whether the database is connected.
   */
  public function isConnected(bool $forceReCheck = false): bool
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

  protected function setStatus(int $status): self
  {
    $this->status = $status;

    return $this;
  }

  protected function setFilesystem(Filesystem $filesystem): self
  {
    $this->filesystem = $filesystem;

    $this->generateDirectories();

    return $this;
  }

  protected function setContainer(Container $container): self
  {
    $this->container = $container;

    $this->rebind();

    \Illuminate\Support\Facades\Facade::setFacadeApplication($this->container);

    return $this;
  }

  protected function setLogs(LogManager $logManager): self
  {
    $this->logs = $logManager;

    return $this;
  }

  protected function setRequest(Request $request): self
  {
    $this->request = $request;

    return $this;
  }

  protected function setSession(SessionManager $session): self
  {
    $session->setId('pkx');
    $session->setRequestOnHandler($this->request);

    $this->session = $session;

    $this->session->start();
    ray($this->session);

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

  protected function setCache(CacheManager $cache): self
  {
    $this->cache = $cache;

    return $this;
  }

  protected function setOptions(Options $options): self
  {
    $this->options = $options;

    return $this;
  }

  private function generateDirectories(): void
  {
    if (!$this->filesystem->isDirectory($this->configuration->get('view.compiled', 'storage/blade'))) {
      $this->filesystem->makeDirectory($this->configuration->get('view.compiled', 'storage/blade'));
    }

    if (!$this->filesystem->isDirectory($this->configuration->get('storage.logs', 'storage/logs'))) {
      $this->filesystem->makeDirectory($this->configuration->get('storage.logs', 'storage/logs'));
    }

    if (!$this->filesystem->isDirectory($this->configuration->get('cache.stores.file.path', 'storage/cache'))) {
      $this->filesystem->makeDirectory($this->configuration->get('cache.stores.file.path', 'storage/cache'));
    }
  }
}
