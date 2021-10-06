<?php

namespace App\Core\Auth;

use App\Core\Auth\User;

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

  public static function register(User $user): bool
  {
    return false;
  }
}
