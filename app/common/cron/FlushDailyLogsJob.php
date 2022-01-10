<?php

namespace App\Common\Cron;

use App\Core\Cron\Job;
use App\Common\Money\Crypto\CoinApi;
use App\Core\Utils\Path;

/**
 * CRON job for updating crypto.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class FlushDailyLogsJob extends Job
{
  public function getName(): string
  {
    return 'FlushDailyLogs';
  }

  public function getInterval(): string
  {
    return '1 WEEK';
  }

  public function process(): void
  {
    $files = array_diff(scandir(Path::getAppPath('storage/logs/')), ['.', '..']);

    foreach ($files as $singleFile) {
      if (str_contains($singleFile, 'daily-')) {
        $this->removeLog($singleFile);
      }
    }
  }

  private function removeLog(string $singleFile): void
  {
    if (!str_contains($singleFile, '.log')) {
      return;
    }

    $date = str_replace(['daily-', '.log'], ['', ''], $singleFile);

    if (empty($date)) {
      return;
    }

    if (strtotime($date . ' 00:00:00') > strtotime('-7 days')) {
      return;
    }

    $fullPath = Path::getAppPath('storage/logs/' . $singleFile);

    if (is_file($fullPath)) {
      unlink($fullPath);
    }
  }
}
