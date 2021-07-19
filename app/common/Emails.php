<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common;

use App\Core\Mailer;
use App\Core\Components\User;

/**
 * @author Leszek P.
 */
final class Emails
{
  public static function sendEmailConfirmation(string $email, string $confirmationLink): bool
  {
    $mailer = new Mailer();

    $mailer->addSection([
      'header' => App::translate('Thank you for your registration.'),
      'message' => App::translate('You have successfully registered on the Polkryptex website. Confirm your email address with the button below to validate your account and log in.'),
      'buttons' => [['name' => App::translate('Confirm your email'), 'url' => $confirmationLink, 'color' => '#5D9CEC']],
      'background' => '#f8f8f8'
    ]);

    return $mailer->send($email, App::translate('Welcome to the Polkryptex army!'));
  }

  public static function sendPasswordChanged(User $user): bool
  {
    $mailer = new Mailer();

    $mailer->addSection([
      'header' => App::translate('Your password has been changed.'),
      'message' => App::translate('Your password has been changed under your user account. You can log in using the button below.'),
      'buttons' => [['name' => App::translate('Log in to your account'), 'url' => App::getUrl('signin'), 'color' => '#5D9CEC']],
      'background' => '#f8f8f8'
    ]);

    return $mailer->send($user->getEmail(), App::translate('Your password has been changed'));
  }
}
