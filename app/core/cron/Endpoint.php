<?php

namespace App\Core\Cron;

use App\Core\View\Request;
use App\Core\Cron\Cron;
use App\Core\Http\Status;

/**
 * Extends the Request class for CRON endpoint.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Endpoint extends Request
{
  public function getAction(): string
  {
    return 'CronEndpoint';
  }

  public function process(): void
  {
    // TODO: Validate URL key in segment 2
    // https://polkryptex.lan/cron/run/{key}

    Cron::run();
  }

  public function print(): void
  {
    if (method_exists($this, 'process')) {
      $this->{'process'}();
    } else {
      $this->addContent('error', 'Non-existent action');
      $this->finish(self::ERROR_ACTION_INVALID, Status::BAD_REQUEST);
    }

    $this->finish(self::CODE_SUCCESS);
  }
}
