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
final class Vue
{
    public function __construct()
    {

    }

    public static function compile(string $path, string $target)
    {
        $files = scandir($path);
        dump($files);
        exit;
    }

    public function getHash()
    {

    }
}
