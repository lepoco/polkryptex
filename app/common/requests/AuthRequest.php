<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common\Requests;

use App\Core\Registry;
use App\Core\Request;
use App\Core\Components\Query;
use App\Core\Components\Crypter;

/**
 * @author Leszek P.
 */
final class AuthRequest extends Request
{
    public function action(): void
    {
        $this->finish(self::CODE_SUCCESS);
    }
}
