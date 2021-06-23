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
use App\Core\Components\User;
use App\Core\Components\Crypter;

/**
 * @author Szymon K.
 */
final class SignInRequest extends Request
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

        $this->validate([
            ['email', FILTER_SANITIZE_STRING],
            ['password', FILTER_SANITIZE_STRING]
        ]);

        $user = User::findByEmail($this->getData('email'));

        if (!$user->isValid()) {
            $this->finish(self::ERROR_PASSWORDS_DONT_MATCH);
        }

        if (!$user->checkPassword($this->getData('password'))) {
            $this->finish(self::ERROR_PASSWORDS_DONT_MATCH);
        }

        $cookieToken = Crypter::salter(64, 'ULN');
        $this->addContent('token', $cookieToken);

        Registry::get('Account')->signIn($user, $cookieToken);
        $this->finish(self::CODE_SUCCESS);
    }
}
