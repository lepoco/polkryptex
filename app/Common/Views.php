<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common;

use Polkryptex\Core\Singleton as App;

/**
 * @author Leszek P.
 */
final class Views
{
    public static function display(string $name)
    {
        App::get()->variables->set('pagenow', $name);
        $controller = 'Polkryptex\\Controllers\\' . $name;

        if (!class_exists($controller)) {
            $controller = 'Polkryptex\\Controllers\\Controller';
        }

        return new $controller();
    }
}
