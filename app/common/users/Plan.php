<?php

namespace App\Common\Users;

use App\Core\Utils\Cast;
use App\Core\Facades\{DB, Cache};
use App\Core\Data\Encryption;

/**
 * Represents an object with user subscription information.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Plan extends \App\Core\Data\DatabaseObject
{
  /**
   * Gets the ID of a plan based on its name.
   */
  public static function getPlanId(string $planName): int
  {
    return Cache::remember('user.plan_id' . $planName, 120, function () use ($planName) {
      $plan = DB::table('plans')->where('name', $planName)->first();

      if (empty($plan)) {
        return 1;
      }

      return (int) $plan->id;
    });
  }

  public static function build(array $parameters): self
  {
    return new self();
  }
}
