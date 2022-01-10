<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\WalletsRepository;
use App\Core\Auth\Account;
use App\Core\View\Blade\Composer;
use App\Core\Http\Redirect;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/topup.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class TopupComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();
    $wallets = WalletsRepository::getUserWallets($user->getId());

    $wallets = array_filter($wallets, fn ($wallet) => !$wallet->getCurrency()->isValid() || !$wallet->getCurrency()->isCrypto());

    // Redirect if user has no wallets
    if (empty($wallets)) {
      Redirect::to('dashboard/add/');
    }

    $view->with('user', $user);
    $view->with('user_wallets', $wallets);
    $view->with('has_wallets', !empty($wallets));
  }
}
