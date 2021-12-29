<?php

namespace App\Common\Composers\Dashboard;

use App\Common\Money\TransactionsRepository;
use App\Core\Facades\Request;
use App\Core\Auth\{Account, User};
use App\Core\View\Blade\Composer;
use App\Core\Http\Redirect;
use Illuminate\View\View;

/**
 * Additional logic for the views/dashboard/transactions.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class TransactionsComposer extends Composer implements \App\Core\Schema\Composer
{
  private const TRANSACTIONS_COUNT = 14;

  public function compose(View $view): void
  {
    $segments = Request::segments();
    $page = 0;
    $offset = 0;

    if (isset($segments[2])) {
      $page = (int) $segments[2];
    }

    $offset = $page;

    if ($offset < 0) {
      $offset = 0;
    }

    if ($offset > 100) {
      $offset = 100;
    }

    $offset *= self::TRANSACTIONS_COUNT;

    $user = Account::current();
    $recentTransactions = $this->getRecentTransactions($user, $offset);
    $moreTransactions = $this->getRecentTransactions($user, $offset + self::TRANSACTIONS_COUNT);

    if (count($recentTransactions) < 1 && $page > 0) {
      Redirect::to('dashboard/transactions');
    }

    $hasNavigation = false;

    if ($page > 0) {
      $hasNavigation = true;
    }

    if ($page > 1) {
      $view->with('previousPageUrl', Redirect::url('dashboard/transactions/' . ($page - 1)));
    } else {
      $view->with('previousPageUrl', Redirect::url('dashboard/transactions'));
    }

    if (count($moreTransactions) > 0) {
      $hasNavigation = true;
    }

    $view->with('user', $user);
    $view->with('page', $page);
    $view->with('transactions', $recentTransactions);
    $view->with('hasMoreTransactions', count($moreTransactions) > 0);
    $view->with('nextPageUrl', Redirect::url('dashboard/transactions/' . ($page + 1)));
    $view->with('hasNavigation', $hasNavigation);
    $view->with('hasTransactions', !empty($recentTransactions));
  }

  private function getRecentTransactions(User $user, int $offset): array
  {
    return TransactionsRepository::getUserTransactions('all', self::TRANSACTIONS_COUNT, $offset);
  }
}
