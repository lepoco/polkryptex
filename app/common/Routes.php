<?php

namespace App\Common;

use App\Core\Http\Router;

/**
 * Abstraction for the router. Contains information about paths.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 * @see https://github.com/bramus/router
 */
final class Routes extends Router
{
  protected string $signInRedirect = 'signin';
  protected string $signedInRedirect = 'dashboard';
  protected string $unconfirmedNamespace = 'Dashboard\Unconfirmed';
  protected string $unocnfirmedRedirect = 'dashboard/unconfirmed';

  /**
   * @var array $routes HTTP paths and Namespaces. The namespace should be in the Pascal Case (Studly Case).
   */
  protected array $routes = [

    // Public
    [
      'path' => '',
      'namespace' => 'Home',
      'redirect_logged' => true
    ],
    [
      'path' => '/register',
      'namespace' => 'Register',
      'redirect_logged' => true
    ],
    [
      'path' => '/register/confirm',
      'namespace' => 'RegisterConfirm',
      //'redirect_logged' => true
    ],
    [
      'path' => '/register/confirmation',
      'namespace' => 'RegisterConfirmation',
      'redirect_logged' => true,
      'require_nonce' => true
    ],
    [
      'path' => '/signin',
      'namespace' => 'SignIn',
      'redirect_logged' => true
    ],
    [
      'path' => '/dashboard/unconfirmed',
      'namespace' => 'Dashboard\\Unconfirmed',
      'require_login' => true
    ],
    [
      'path' => '/contact',
      'namespace' => 'Contact',
    ],
    [
      'path' => '/licenses',
      'namespace' => 'Licenses',
    ],
    [
      'path' => '/terms',
      'namespace' => 'Terms',
    ],
    [
      'path' => '/privacy',
      'namespace' => 'Privacy',
    ],
    [
      'path' => '/legal',
      'namespace' => 'Legal',
    ],

    // Dashboard | User
    [
      'path' => '/dashboard',
      'namespace' => 'Dashboard\\Main',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/password',
      'namespace' => 'Dashboard\\Password',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/account',
      'namespace' => 'Dashboard\\Account',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/billing',
      'namespace' => 'Dashboard\\Billing',
      'require_login' => true,
      'permission' => 'billing',
      'redirect_no_permission' => 'dashboard/account'
    ],
    [
      'path' => '/dashboard/payments',
      'namespace' => 'Dashboard\\Payments',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/payments/send',
      'namespace' => 'Dashboard\\PaymentsSend',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/payments/request',
      'namespace' => 'Dashboard\\PaymentsRequest',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/transactions',
      'namespace' => 'Dashboard\\Transactions',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/transactions/{page}',
      'namespace' => 'Dashboard\\Transactions',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/transaction/{uuid}',
      'namespace' => 'Dashboard\\Transaction',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/add',
      'namespace' => 'Dashboard\\Add',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/topup',
      'namespace' => 'Dashboard\\Topup',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/exchange',
      'namespace' => 'Dashboard\\Exchange',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/plan',
      'namespace' => 'Dashboard\\Plan',
      'require_login' => true
    ],
    [
      'path' => '/dashboard/cards/add',
      'namespace' => 'Dashboard\\CardsAdd',
      'require_login' => true
    ],

    // Admin panel
    [
      'path' => '/panel',
      'namespace' => 'Panel\\Main',
      'require_login' => true,
      'permission' => 'admin_panel',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/statistics',
      'namespace' => 'Panel\\Statistics',
      'require_login' => true,
      'permission' => 'admin_statistics',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/users',
      'namespace' => 'Panel\\Users',
      'require_login' => true,
      'permission' => 'admin_users',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/users/add',
      'namespace' => 'Panel\\UsersAdd',
      'require_login' => true,
      'permission' => 'admin_users',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/user/{uuid}',
      'namespace' => 'Panel\\User',
      'require_login' => true,
      'permission' => 'admin_single_user',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/cron',
      'namespace' => 'Panel\\Cron',
      'require_login' => true,
      'permission' => 'admin_cron',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/tools',
      'namespace' => 'Panel\\Tools',
      'require_login' => true,
      'permission' => 'admin_tools',
      'redirect_no_permission' => 'dashboard'
    ],
    [
      'path' => '/panel/settings',
      'namespace' => 'Panel\\Settings',
      'require_login' => true,
      'permission' => 'admin_settings',
      'redirect_no_permission' => 'dashboard'
    ]
  ];
}
