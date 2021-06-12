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
final class Views
{
    private const CONTROLLER_NAMESPACE = 'Polkryptex\\Common\\Controllers\\';

    public static function display(string $namespace)
    {
        $controller = self::CONTROLLER_NAMESPACE . $namespace;
        if (!class_exists($controller)) {
            return new \Polkryptex\Core\Controller($namespace);
        }

        return new $controller($namespace);
    }
}
