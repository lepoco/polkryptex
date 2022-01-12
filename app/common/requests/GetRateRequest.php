<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\{Account, User};

/**
 * Action triggered during searching for currency rate.
 *
 * @author  Kujawski <szymon@polkryptex.pl>
 * @license GPL-3.0 h ttps://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class GetRateRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'GetRate';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'from',
      'to'
    ]);

    $this->isEmpty([
      'id',
      'from',
      'to'
    ]);
  }
}
