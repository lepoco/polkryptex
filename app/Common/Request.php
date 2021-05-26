<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common;

/**
 * @author Leszek P.
 */
final class Request
{
    public function __construct()
    {
        dump($_REQUEST);
        exit;
    }
}
