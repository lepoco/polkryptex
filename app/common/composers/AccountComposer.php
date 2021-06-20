<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Composers;

use Illuminate\View\View;
use Polkryptex\Core\Registry;

/**
 * @author Leszek P.
 */
final class AccountComposer
{
    public function compose(View $view)
    {
        $view->with('user', Registry::get('Account')->currentUser());
    }
}
