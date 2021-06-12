<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Controllers\Dashboard;

use Polkryptex\Core\Controller;
use Polkryptex\Core\Registry;

/**
 * @author Leszek P.
 */
final class Dashboard extends Controller
{
    public function init()
    {
        if(!Registry::get('User')->isLoggedIn())
        {
            $this->redirect('signin'); //home
        }
    }

    public static function testDebugPrint()
    {
        return 'This is a return from function';
    }
}
