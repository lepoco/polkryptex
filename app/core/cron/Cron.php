<?php

namespace App\Core\Cron;

use DateTime;
use App\Core\Utils\Path;
use App\Core\Facades\DB;

/**
 * Extends the Repository class containing the application's configuration to the name Config. Uses the Laravel scheme.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Cron
{
  private const NAMESPACE = '\\App\\Common\\Cron\\';

  public static function run()
  {
    return new self();
  }

  public function __construct()
  {
    $jobLists = $this->getJobsLists();

    foreach ($jobLists as $key => $job) {
      $this->runJob($job);
    }
  }

  private function runJob(string $jobClassName): bool
  {
    try {
      $jobInstance = new $jobClassName();
    } catch (\Throwable $th) {
      return false;
    }

    $jobName = str_replace('job', '_job', strtolower(trim($jobInstance->getName())));

    if (!$this->isTimePassed($jobName, $jobInstance->getInterval())) {
      return false;
    }

    $jobInstance->process();

    $this->updateJob($jobName);

    return true;
  }

  private function isTimePassed(string $name, string $interval): bool
  {
    $jobInfo = $this->getJob($name);

    if (empty($jobInfo)) {
      return true;
    }

    $difference = $this->getElapsedMinutes($jobInfo['last_run']);
    $interval = $this->getIntervalInMinutes($interval);

    if ($interval < 1) {
      return false;
    }

    return $difference > $interval;
  }

  private function getIntervalInMinutes(string $interval): int
  {
    $interval = trim(strtolower($interval));
    $intervalParams = explode(' ', $interval);
    $intervalParams[0] = intval($intervalParams[0]);

    $intervalInMinutes = 0;

    if (str_contains($intervalParams[1], 'm')) {
      $intervalInMinutes = $intervalParams[0];
    } elseif (str_contains($intervalParams[1], 'h')) {
      $intervalInMinutes = $intervalParams[0] * 60;
    } elseif (str_contains($intervalParams[1], 'd')) {
      $intervalInMinutes = $intervalParams[0] * 60 * 24;
    }

    if ($intervalInMinutes < 1) {
      $intervalInMinutes = 0;
    }

    return $intervalInMinutes;
  }

  private function getElapsedMinutes(string $time): int
  {
    $timeNow = new DateTime('now');
    $timeLastRun = new DateTime($time);

    $difference = abs(($timeNow->getTimestamp() - $timeLastRun->getTimestamp()) / 60);

    return (int) $difference;
  }

  private function updateJob(string $name): void
  {
    $query = DB::table('cron')->where(['name' => $name])->get('*')->first();

    if (!isset($query->id)) {
      DB::table('cron')->insertGetId([
        'name' => $name,
        'last_run' => date('Y-m-d H:i:s'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ]);

      return;
    }

    DB::table('cron')->where('id', $query->id)->update([
      'last_run' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }

  private function getJob(string $name): array
  {
    $query = DB::table('cron')->where(['name' => $name])->get('*')->first();

    if (!isset($query->last_run)) {
      return [];
    }

    return [
      'id' => $query->id,
      'name' => $name,
      'last_run' => $query->last_run,
      'created_at' => $query->created_at,
      'updated_at' => $query->updated_at
    ];
  }

  private function getJobsLists(): array
  {
    $files = array_diff(scandir(Path::getAppPath('common/cron/')), ['.', '..']);

    return array_map(function ($file) {
      if (str_ends_with($file, '.php')) {
        return self::NAMESPACE . str_replace('.php', '', $file);
      }
    }, $files);
  }
}
