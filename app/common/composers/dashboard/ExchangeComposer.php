<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\WalletsRepository;
use App\Core\Auth\Account;
use App\Core\Http\Redirect;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/exchange.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class ExchangeComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();
    $wallets = WalletsRepository::getUserWallets($user->getId());

    // Redirect if user has no wallets
    if (empty($wallets)) {
      Redirect::to('dashboard/add/');
    }

    $view->with('user', $user);
    $view->with('has_one_wallet', count($wallets) === 1);
    $view->with('user_wallets', $wallets);
    $view->with('has_wallets', !empty($wallets));
  }
}
