<?php

namespace App\Common\Composers\Dashboard;

use App\Core\Auth\{User, Account};
use App\Core\Http\Redirect;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * Additional logic for the views/dashboard/payments.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class PaymentsComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $user = Account::current();

    $view->with('user', $user);
    $view->with('payments', $this->getPayments($user));
  }

  private function getPayments(User $user): array
  {
    return [
      [
        'date' => 'Today',
        'transactions' => [
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
        ]
      ]
    ];
  }
}
