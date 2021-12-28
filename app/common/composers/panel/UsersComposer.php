<?php

namespace App\Common\Composers\Panel;

use App\Core\Facades\DB;
use App\Core\Auth\{Account, User};
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/panel/users.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class UsersComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    /** @var User[] $users */
    $users = $this->getUsers();

    if (isset($users[0]) && $users[0]->id() === 1) {
      array_shift($users);
    }

    usort($users, fn($a, $b) => $a->id() - $b->id());

    $view->with('user', Account::current());
    $view->with('users', $users);
  }

  private function getUsers(): array
  {
    $users = [];
    $dbUsers = DB::table('users')->get(['id'])->all();

    if (empty($dbUsers)) {
      return [];
    }

    foreach ($dbUsers as $singleUser) {
      if (isset($singleUser->id) && !empty($singleUser->id)) {
        $users[] = new User($singleUser->id);
      }
    }

    return $users;
  }
}
