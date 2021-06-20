<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Requests;

use Polkryptex\Core\Registry;
use Polkryptex\Core\Request;
use Polkryptex\Core\Components\User;
use Polkryptex\Core\Components\Crypter;

/**
 * @author Szymon K.
 */
final class SignInRequest extends Request
{
    public function action(): void
    {
        $this->isSet([
            'username',
            'password'
        ]);

        $this->isEmpty([
            'username',
            'password'
        ]);

        $this->validate([
            ['username', FILTER_SANITIZE_STRING],
            ['password', FILTER_SANITIZE_STRING]
        ]);

        $user = User::find($this->getData('username'));

        if (!$user->isValid()) {
            $this->finish(self::ERROR_PASSWORDS_DONT_MATCH);
        }

        if (!$user->checkPassword($this->getData('password'))) {
            $this->finish(self::ERROR_PASSWORDS_DONT_MATCH);
        }

        $cookieToken = Crypter::salter(32);
        $this->addContent('token', $cookieToken);

        Registry::get('Account')->signIn($user, $cookieToken);
        $this->finish(self::CODE_SUCCESS);
    }
}
