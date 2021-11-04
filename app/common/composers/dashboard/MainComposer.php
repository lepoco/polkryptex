<?php

namespace App\Common\Composers\Dashboard;

use App\Core\Auth\{Account, User};
use App\Core\View\Blade\Composer;
use App\Core\Http\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * Additional logic for the views/dashboard/main.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class MainComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    $view->with('user', $user);
    $view->with('recentTransactions', $this->getRecentTransactions($user));
  }

  private function getRecentTransactions(User $user): array
  {
    return [
      [
        'url' => Redirect::url('dashboard/transactions/' . Str::uuid()),
        'amount' => 55.22,
        'currency' => 'EUR',
        'date' => date('Y-m-d H:i'),
        'description' => 'Transfer',
      ],
      [
        'url' => Redirect::url('dashboard/transactions/' . Str::uuid()),
        'amount' => 55.22,
        'currency' => 'EUR',
        'date' => date('Y-m-d H:i'),
        'description' => 'Exchange',
      ],
      [
        'url' => Redirect::url('dashboard/transactions/' . Str::uuid()),
        'amount' => 55.22,
        'currency' => 'EUR',
        'date' => date('Y-m-d H:i'),
        'description' => 'Exchange',
      ],
      [
        'url' => Redirect::url('dashboard/transactions/' . Str::uuid()),
        'amount' => 55.22,
        'currency' => 'EUR',
        'date' => date('Y-m-d H:i'),
        'description' => 'Exchange',
      ],
      [
        'url' => Redirect::url('dashboard/transactions/' . Str::uuid()),
        'amount' => 55.22,
        'currency' => 'EUR',
        'date' => date('Y-m-d H:i'),
        'description' => 'Exchange',
      ]
    ];
  }
}
