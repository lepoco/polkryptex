<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace Polkryptex\Common\Requests;

use Polkryptex\Core\Request;
use Polkryptex\Core\Registry;
use Polkryptex\Core\Components\Query;

/**
 * @author Szymon K. Leszek P.
 */
final class RegisterRequest extends Request
{
    public function action(): void
    {
        $this->isSet([
            'username',
            'email',
            'password',
            'password_confirm'
        ]);

        $this->isEmpty([
            'username',
            'email',
            'password',
            'password_confirm'
        ]);

        $this->validate([
            ['username', FILTER_SANITIZE_STRING],
            ['email', FILTER_SANITIZE_STRING],
            ['password'],
            ['password_confirm']
        ]);

        if(strlen($this->getData('password')) < 8)
        {
            $this->finish(self::ERROR_PASSWORD_TOO_SHORT);
        }

        if($this->getData('password') != $this->getData('password_confirm'))
        {
            $this->finish(self::ERROR_PASSWORDS_DONT_MATCH);
        }

        $query = Query::getUserByName($this->getData('username'));
        if(!empty($query))
        {
            $this->finish(self::ERROR_USER_NAME_EXISTS);
        }

        $query = Query::getUserByEmail($this->getData('email'));
        if(!empty($query))
        {
            $this->finish(self::ERROR_USER_EMAIL_EXISTS);
        }

        Query::addUser($this->getData('username'), $this->getData('email'), $this->getData('password'));

        $this->finish(self::CODE_SUCCESS);
    }
}
