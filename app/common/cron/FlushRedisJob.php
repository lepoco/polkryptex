<?php

namespace App\Common\Cron;

use App\Core\Cron\Job;
use App\Common\Money\Crypto\CoinApi;
use App\Core\Facades\Cache;
use App\Core\Utils\Path;

/**
 * CRON job for updating crypto.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class FlushRedisJob extends Job
{
  public function getName(): string
  {
    return 'FlushRedis';
  }

  public function getInterval(): string
  {
    return '1 DAY';
  }

  public function process(): void
  {
    if (Cache::isConnected()) {
      Cache::flush();

      Cache::close();
    }
  }
}
