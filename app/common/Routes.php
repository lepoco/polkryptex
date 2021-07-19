<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common;

use App\Core\Router;
use App\Core\Debug;

final class Routes extends Router
{
  public function initialize(): void
  {
    if (!defined('APP_VERSION')) {
      $this->register('', 'Installer', ['title' => 'Installer', 'fullscreen' => true]);
      $this->run();

      return;
    }

    if (Debug::isDebug()) {
      $this->register('/debug', 'Debug');
    }

    $this->register('', 'Home', ['title' => 'Home']);
    $this->register('/register', 'Register', ['title' => 'Register', 'fullscreen' => true]);
    $this->register('/signin', 'SignIn', ['title' => 'Sign In', 'fullscreen' => true]);
    $this->register('/plans', 'Plans', ['title' => 'Plans']);
    $this->register('/help', 'Help', ['title' => 'Help']);

    $this->register('/dashboard', 'Dashboard\\Dashboard', ['title' => 'Dashboard', 'requireLogin' => true]);
    $this->register('/dashboard/wallet', 'Dashboard\\Wallet', ['title' => 'Wallet', 'requireLogin' => true]);
    $this->register('/dashboard/wallet/transfer', 'Dashboard\\WalletTransfer', ['title' => 'Transfer', 'requireLogin' => true]);
    $this->register('/dashboard/wallet/exchange', 'Dashboard\\WalletExchange', ['title' => 'Exchange', 'requireLogin' => true]);
    $this->register('/dashboard/wallet/topup', 'Dashboard\\WalletTopup', ['title' => 'Top Up', 'requireLogin' => true]);
    $this->register('/dashboard/account', 'Dashboard\\Account', ['title' => 'Account', 'requireLogin' => true]);
    $this->register('/dashboard/account/two-step', 'Dashboard\\AccountTwoStep', ['title' => '2FA Authentication', 'requireLogin' => true]);
    $this->register('/dashboard/account/change-password', 'Dashboard\\AccountNewPassword', ['title' => 'Change your password', 'requireLogin' => true]);

    $this->register('/admin', 'Admin\\Admin', ['title' => 'Admin Dashboard', 'requireLogin' => true, 'permissions' => ['all']]);
    $this->register('/admin/users', 'Admin\\AdminUsers', ['title' => 'Admin Users', 'requireLogin' => true, 'permissions' => ['all']]);
    $this->register('/admin/configuration', 'Admin\\AdminConfiguration', ['title' => 'Admin Configuration', 'requireLogin' => true, 'permissions' => ['all']]);
    $this->register('/admin/tools', 'Admin\\AdminTools', ['title' => 'Admin Tools', 'requireLogin' => true, 'permissions' => ['all']]);

    $this->register('/private', 'Static\\Private', ['title' => 'Private']);
    $this->register('/business', 'Static\\Business', ['title' => 'Business']);
    $this->register('/licenses', 'Static\\Licenses', ['title' => 'Licenses']);
  }
}
