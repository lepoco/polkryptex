<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Requests;

use Polkryptex\Core\Request;

/**
 * @author Leszek P.
 */
final class SignIn extends Request
{
    public function action(): void
    {
        $this->isSet([
            'email',
            'password'
        ]);

        $this->isEmpty([
            'email',
            'password'
        ]);

        $this->filter([
            ['email'],
            ['password']
        ]);

        $this->finish(self::CODE_SUCCESS);
    }
}
