<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Controllers;

use Polkryptex\Core\Controller;

/**
 * @author Leszek P.
 */
final class Home extends Controller
{
    public function init()
    {
        $this->setTitle('Home');
    }

    public static function testDebugPrint()
    {
        return 'This is a return from function';
    }
}
