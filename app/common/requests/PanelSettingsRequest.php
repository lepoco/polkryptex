<?php

namespace App\Common\Requests;

use App\Common\Money\{WalletsRepository, CurrenciesRepository, Wallet};
use App\Core\Facades\{Translate, Statistics, Option};
use App\Core\View\Request;
use App\Core\Http\{Status, Redirect};
use App\Core\Auth\Account;

/**
 * Action triggered during adding a wallet.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class PanelSettingsRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'PanelSettings';
  }

  public function process(): void
  {
    $this->isSet([
      'language',
      'site_name',
      'base_url',
      'home_url',
      'signout_time',
      'cookie_name',
      'mail_smtp_host',
      'mail_smtp_user',
      'mail_smtp_password',
      'mail_smtp_port',
      'mail_smtp_encryption',
      'mail_sendname',
      'mail_sendfrom',
      'mail_replyto',
      'mail_legal'
    ]);

    $this->isEmpty([
      'language',
      'site_name',
      'base_url',
      'home_url',
      'signout_time',
      'cookie_name',
      'mail_smtp_encryption',
      'mail_sendname',
      'mail_sendfrom',
      'mail_replyto',
      'mail_legal'
    ]);

    $this->validate([
      ['language', self::SANITIZE_STRING],
      ['site_name', self::SANITIZE_STRING],
      ['base_url', self::SANITIZE_STRING],
      ['home_url', self::SANITIZE_STRING],
      ['signout_time', FILTER_VALIDATE_INT],
      ['cookie_name', self::SANITIZE_STRING],
      ['mail_smtp_encryption', self::SANITIZE_STRING],
      ['mail_sendname', self::SANITIZE_STRING],
      ['mail_sendfrom', FILTER_VALIDATE_EMAIL],
      ['mail_replyto', FILTER_VALIDATE_EMAIL],
      ['mail_legal', self::SANITIZE_STRING]
    ]);

    $user = Account::current();

    if (empty($user)) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    if (!Account::hasPermission('all', $user)) {
      $this->addContent('message', Translate::string('You are not authorized to perform this action.'));
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    Option::set('language', $this->get('language'));
    Option::set('site_name', $this->get('site_name'));
    Option::set('base_url', $this->get('base_url'));
    Option::set('home_url', $this->get('home_url'));
    Option::set('signout_time', $this->get('signout_time'));
    Option::set('cookie_name', $this->get('cookie_name'));
    Option::set('mail_sendname', $this->get('mail_sendname'));
    Option::set('mail_sendfrom', $this->get('mail_sendfrom'));
    Option::set('mail_replyto', $this->get('mail_replyto'));
    Option::set('mail_legal', $this->get('mail_legal'));

    Option::set('mail_smtp_encryption', $this->get('mail_smtp_encryption'));

    Option::set('mail_smtp_host', $this->optional('mail_smtp_host'));
    Option::set('mail_smtp_user', $this->optional('mail_smtp_user'));

    // Do not expose the real password in frontend
    if ($this->optional('mail_smtp_password') !== 'hiddenpasswordhiddenpassword') {
      Option::set('mail_smtp_password', $this->optional('mail_smtp_password'));
    }

    Option::set('mail_smtp_port', $this->optional('mail_smtp_port'));

    Option::set('service_worker_enabled', $this->isTrue('service_worker_enabled'));
    Option::set('stastistics_keep_ip', $this->isTrue('stastistics_keep_ip'));
    Option::set('mail_smtp_enabled', $this->isTrue('mail_smtp_enabled'));
    Option::set('mail_smtp_auth', $this->isTrue('mail_smtp_auth'));

    $this->addContent('message', Translate::string('Site settings have been updated.'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
