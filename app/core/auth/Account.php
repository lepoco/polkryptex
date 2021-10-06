<?php

namespace App\Core\Auth;

use App\Core\Auth\User;
use App\Core\Facades\DB;
use Illuminate\Support\Str;

/**
 * Used to manage user accounts
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Account
{
  public static function current(): ?User
  {
    return null;
  }

  public static function signIn(User $user): bool
  {
    return false;
  }

  public static function signOut(User $user): bool
  {
    return false;
  }

  public static function getRoleId(string $roleName): int
  {
    $role = DB::table('user_roles')->where('name', $roleName)->first();

    if (empty($role)) {
      return 1;
    }

    return (int) $role->id;
  }

  public static function getPlanId(string $planName): int
  {
    $plan = DB::table('plans')->where('name', $planName)->first();

    if (empty($plan)) {
      return 1;
    }

    return (int) $plan->id;
  }

  public static function register(User $user, string $encryptedPassword): bool
  {
    $users = DB::table('users')->get(['*'])->where('email', $user->getEmail());

    if ($users->count() > 0) {
      return false;
    }

    return (bool) DB::table('users')->insert([
      'email' => $user->getEmail(),
      'name' => $user->getName(),
      'uuid' => Str::uuid(),
      'display_name' => $user->getDisplayName(),
      'password' => $encryptedPassword,
      'role_id' => self::getRoleId('admin')
    ]);
  }
}
