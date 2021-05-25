<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Polkryptex\Common\Debug;
use Polkryptex\Common\Router;

final class Application
{
    private $providers = [];

    private Debug $debug;

    private Router $router; 

    private function __construct()
    {
        Singleton::set($this);

        $this->debug = new Debug();
        $this->router = new Router();

        //Symfony\Component\VarDumper\VarDumper\dump
        exit(dump($this));
    }

    /**
     * Returns a new application instance, should be triggered by public/index.php
     * @return Application
     */
    static function start(): Application
    {
        return new Application();
    }

    private function register(): void
    {
        //
    }

    private function get()
    {
    }
}
