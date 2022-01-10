<?php

namespace App\Common\Composers\Panel;

use FilesystemIterator;
use App\Core\Facades\{DB, Statistics, Config, Option};
use App\Core\Auth\{Account, User};
use App\Core\Cron\Cron;
use App\Core\Data\Encryption;
use App\Core\Http\Redirect;
use App\Core\Utils\Path;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/panel/tools.blade view.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class ToolsComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $cronSecret = strtolower(trim(Option::get('cron_secret', Encryption::salter(8, 'LN'))));

    $view->with('user', Account::current());
    $view->with('cached_blade', $this->getCachedBlade());
    $view->with('cached_records', $this->getCachedRecords());
    $view->with('logs_count', $this->getLogsCount());

    $view->with('jobs', $this->getJobs());
    $view->with('last_run', Option::get('cron_last_run', ''));
    $view->with('secret', $cronSecret);
    $view->with('cron_url', Redirect::url('cron/run/' . $cronSecret));
  }


  private function getCachedBlade(): int
  {
    $bladePath = Config::get('view.compiled', Path::getAppPath('storage/blade'));
    $fileIterator = new FilesystemIterator($bladePath, FilesystemIterator::SKIP_DOTS);

    return iterator_count($fileIterator);
  }

  private function getCachedRecords(): int
  {
    $cachePath = Config::get('cache.stores.file.path', Path::getAppPath('storage/cache'));
    $fileIterator = new FilesystemIterator($cachePath, FilesystemIterator::SKIP_DOTS);

    return iterator_count($fileIterator);
  }

  private function getLogsCount(): int
  {
    $fileIterator = new FilesystemIterator(Path::getAppPath('storage/logs'), FilesystemIterator::SKIP_DOTS);

    return iterator_count($fileIterator);
  }

  private function getJobs(): array
  {
    $cron = new Cron();
    $cronJobs = $cron->getJobs();

    return $cronJobs;
  }
}
