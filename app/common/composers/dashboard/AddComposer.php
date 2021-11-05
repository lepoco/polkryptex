<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\{CurrenciesRepository, WalletsRepository};
use App\Core\Auth\Account;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/add.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class AddComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();
    $currencies = CurrenciesRepository::getAll();
    $wallets = WalletsRepository::getUserWallets($user->getId());

    // Don't show currencies that the user already owns.
    $currencies = array_filter($currencies, function ($currency) use ($wallets) {
      foreach ($wallets as $wallet) {
        if ($wallet->getCurrency()->getId() == $currency->getId()) {
          return false;
        }
      }

      return true;
    });

    $view->with('user', $user);
    $view->with('currencies', $currencies);
    $view->with('has_currencies', !empty($currencies));
  }
}
