<?php

namespace App\Core\Cron;

use DateTime;
use App\Core\Utils\Path;
use App\Core\Facades\{DB, Option};

/**
 * Responsible for cyclical tasks.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Cron
{
  private const NAMESPACE = '\\App\\Common\\Cron\\';

  /**
   * Triggers a new instance of the class.
   */
  public static function run()
  {
    return (new self())->invokeJobs();
  }

  /**
   * Retrieves a list and then tries to run jobs.
   */
  public function invokeJobs(): self
  {
    $jobLists = $this->getJobsClassList();

    foreach ($jobLists as $job) {
      $this->runJob($job);
    }

    Option::set('cron_last_run', new DateTime('now'));

    return $this;
  }

  public function formatName(string $jobName): string
  {
    return str_replace('job', '_job', strtolower(trim($jobName)));
  }

  public function getJobs(): array
  {
    $jobsClassList = $this->getJobsClassList();
    $jobsTable = $this->getJobsTable();

    for ($i = 0; $i < count($jobsTable); $i++) {
      foreach ($jobsClassList as $singleJobClass) {
        try {
          $jobInstance = new $singleJobClass();
        } catch (\Throwable $th) {
          continue;
        }

        $jobParsedName = $this->formatName($jobInstance->getName());

        if ($jobParsedName == $jobsTable[$i]['name']) {
          $jobsTable[$i]['full_name'] = $jobInstance->getName();
          $jobsTable[$i]['class_name'] = $singleJobClass;
          $jobsTable[$i]['interval'] = $jobInstance->getInterval();
        }
      }
    }

    return $jobsTable;
  }

  /**
   * Triggers a new job based on its class name.
   */
  private function runJob(string $jobClassName): bool
  {
    try {
      $jobInstance = new $jobClassName();
    } catch (\Throwable $th) {
      return false;
    }

    $jobName = $this->formatName($jobInstance->getName());

    if (!$this->isTimePassed($jobName, $jobInstance->getInterval())) {
      return false;
    }

    $jobInstance->process();

    $this->updateJob($jobName);

    return true;
  }

  /**
   * Checks whether the selected job should be run.
   */
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

  /**
   * Converts a text interval to minutes.
   */
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

  /**
   * Checks how much time has elapsed since a given date.
   */
  private function getElapsedMinutes(string $time): int
  {
    $timeNow = new DateTime('now');
    $timeLastRun = new DateTime($time);

    $difference = abs(($timeNow->getTimestamp() - $timeLastRun->getTimestamp()) / 60);

    return (int) $difference;
  }

  /**
   * Updates information about a job in the database.
   */
  private function updateJob(string $name): void
  {
    $query = DB::table('cron')->where(['name' => $name])->get('*')->first();

    if (!isset($query->id)) {
      DB::table('cron')->insertGetId([
        'name' => $name,
        'last_run' => date('Y-m-d H:i:s'),
        'created_at' => date('Y-m-d H:i:s')
      ]);

      return;
    }

    DB::table('cron')->where('id', $query->id)->update([
      'last_run' => date('Y-m-d H:i:s')
    ]);
  }

  /**
   * Gets job information from the database.
   */
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
      'created_at' => $query->created_at
    ];
  }

  private function getJobsTable(): array
  {
    $cronJobs = [];
    $results = DB::table('cron')->orderBy('id', 'desc')->get('*');

    foreach ($results as $result) {
      if (isset($result->id)) {
        $cronJobs[] = [
          'id' => $result->id ?? 0,
          'name' => $result->name ?? '__UNKNOWN__',
          'last_run' => $result->last_run ?? '__UNKNOWN__',
          'created_at' => $result->created_at ?? '__UNKNOWN__',
        ];
      }
    }

    return $cronJobs;
  }

  /**
   * Gets a list of job classes.
   */
  private function getJobsClassList(): array
  {
    $files = array_diff(scandir(Path::getAppPath('common/cron/')), ['.', '..']);

    return array_map(function ($file) {
      if (str_ends_with($file, '.php')) {
        return self::NAMESPACE . str_replace('.php', '', $file);
      }
    }, $files);
  }
}
