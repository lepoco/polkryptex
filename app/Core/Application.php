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
use Polkryptex\Common\Variables;

final class Application
{
    /**
     * @link https://packagist.org/packages/monolog/monolog
     */
    public Debug $debug;

    /**
     * @link https://github.com/bramus/router
     */
    public Router $router;

    public Variables $variables;

    private function __construct()
    {
        Singleton::set($this);

        $this->debug = new Debug();
        $this->variables = new Variables();
        $this->router = new Router();
    }

    /**
     * Returns a new application instance, should be triggered by public/index.php
     * @return Application
     */
    static function start(): Application
    {
        return new Application();
    }
}
