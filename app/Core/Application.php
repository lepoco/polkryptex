<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Core;

use Polkryptex\Core\Singleton;

final class Application
{
    private function __construct()
    {
        Singleton::set($this);

        //Symfony\Component\VarDumper\VarDumper\dump
        exit(dump($this));
    }

    static function start()
    {
        return new Application();
    }
}
