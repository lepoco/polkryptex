<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core\Components;

use App\Core\Mailer;
use App\Core\Registry;

/**
 * @author Leszek P.
 */
final class Emails
{
  public static function sendEmailConfirmation(string $email, string $confirmationLink): bool
  {
    $mailer = new Mailer();

    $mailer->addSection([
      'header' => self::translate('Thank you for your registration.'),
      'message' => self::translate('You have successfully registered on the Polkryptex website. Confirm your email address with the button below to validate your account and log in.'),
      'buttons' => [['name' => self::translate('Confirm your email'), 'url' => $confirmationLink, 'color' => '#5D9CEC']],
      'background' => '#f8f8f8'
    ]);

    return $mailer->send($email, self::translate('Welcome to the Polkryptex army!'));
  }

  public static function sendPasswordChanged(User $user): bool
  {
    $mailer = new Mailer();

    $mailer->addSection([
      'header' => self::translate('Your password has been changed.'),
      'message' => self::translate('Your password has been changed under your user account. You can log in using the button below.'),
      'buttons' => [['name' => self::translate('Log in to your account'), 'url' => self::getUrl('signin'), 'color' => '#5D9CEC']],
      'background' => '#f8f8f8'
    ]);

    return $mailer->send($user->getEmail(), self::translate('Your password has been changed'));
  }

  private static function getUrl(?string $path = null): string
  {
    return Registry::get('Options')->get('baseurl', (Registry::get('Request')->isSecured() ? 'https://' : 'http://') . Registry::get('Request')->url->host . '/') . $path;
  }

  private static function translate(string $text, ?array $variables = null): ?string
  {
    return Registry::get('Translator')->translate($text, $variables);
  }
}
