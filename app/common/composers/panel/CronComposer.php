<?php

namespace App\Common\Composers\Panel;

use App\Core\Facades\{DB, Option};
use App\Core\Auth\Account;
use App\Core\Cron\Cron;
use App\Core\Data\Encryption;
use App\Core\Http\Redirect;
use App\Core\View\Blade\Composer;
use Illuminate\View\View;

/**
 * Additional logic for the views/panel/cron.blade view.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.0.0
 */
final class CronComposer extends Composer implements \App\Core\Schema\Composer
{
  public function compose(View $view): void
  {
    $cronSecret = strtolower(trim(Option::get('cron_secret', Encryption::salter(8, 'LN'))));

    $view->with('user', Account::current());
    $view->with('jobs', $this->getJobs());
    $view->with('last_run', Option::get('cron_last_run', ''));
    $view->with('secret', $cronSecret);
    $view->with('cron_url', Redirect::url('cron/run/' . $cronSecret));
  }

  private function getJobs(): array
  {
    $cron = new Cron();
    $cronJobs = $cron->getJobs();

    return $cronJobs;
  }
}
