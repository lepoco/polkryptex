<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

/**
 * @author Leszek P.
 */
final class Application
{
    /**
     * @link https://packagist.org/packages/monolog/monolog
     * @link https://github.com/nette/database
     * @link https://github.com/bramus/router
     */

    private function __construct()
    {
        Registry::register('Debug', new Debug());
        Registry::register('Variables', new Variables());
        Registry::register('Database', new Database(), ['\Polkryptex\Core\Components\Options']);
        Registry::register('Options', new Components\Options(), ['\Polkryptex\Core\Controller', '\Polkryptex\Core\Request']);
        Registry::register('User', new Components\User(), ['\Polkryptex\Core\Controller', '\Polkryptex\Core\Request']);
        
        Components\Translator::init();
        Components\Router::init();
    }

    /**
     * Returns a new application instance, should be triggered by public/index.php
     * @return Application
     */
    static function start(): Application
    {
        return new self();
    }

    static function stop()
    {
        exit;
    }
}
