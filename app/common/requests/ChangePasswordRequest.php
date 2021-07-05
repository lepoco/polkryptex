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
use App\Core\Components\Emails;

/**
 * @author Szymon K.
 */
final class ChangePasswordRequest extends Request
{
    public function action(): void
    {
        $this->isSet([
            'id',
            'current_password',
            'new_password',
            'confirm_new_password'
        ]);

        $this->isEmpty([
            'id',
            'current_password',
            'new_password',
            'confirm_new_password'
        ]);

        $this->validate([
            ['id', FILTER_SANITIZE_NUMBER_INT],
            ['current_password', FILTER_SANITIZE_STRING],
            ['new_password', FILTER_SANITIZE_STRING],
            ['confirm_new_password', FILTER_SANITIZE_STRING]
        ]);

        $user = Registry::get('Account')->currentUser();

        if ($user->getId() != $this->getData('id')) {
            $this->finish(self::ERROR_INVALID_USER);
        }

        if (!$user->checkPassword($this->getData('current_password'))) {
            $this->addContent('message', $this->translate('The current password provided is incorrect.'));
            $this->finish(self::ERROR_INVALID_PASSWORD);
        }

        if(strlen($this->getData('new_password')) < 8)
        {
            $this->addContent('message', $this->translate('The password provided is too short.'));
            $this->finish(self::ERROR_PASSWORD_TOO_SHORT);
        }

        if($this->getData('current_password') == $this->getData('new_password'))
        {
            $this->addContent('message', $this->translate('The new password cannot be the same as the old password.'));
            $this->finish(self::ERROR_PASSWORD_CANNOT_BE_SAME);
        }

        if($this->getData('new_password') != $this->getData('confirm_new_password'))
        {
            $this->addContent('message', $this->translate('The new password does not match its confirmation.'));
            $this->finish(self::ERROR_PASSWORDS_DONT_MATCH);
        }

        Query::updateUserPassword($user->getId(), $this->getData('new_password'));
        Emails::sendPasswordChanged($user);

        $this->addContent('message', $this->translate('Your password has been successfully changed.'));
        $this->finish(self::CODE_SUCCESS);
    }
}
