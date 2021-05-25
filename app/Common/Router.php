<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common;

use Bramus\Router\Router as BramusRouter;

final class Router
{
    private BramusRouter $router;

    public function __construct()
    {
        $this->router = new BramusRouter();
    }
}
