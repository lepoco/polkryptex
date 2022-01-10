<?php

namespace App\Common\Cron;

use App\Core\Cron\Job;
use App\Common\Money\Crypto\CoinApi;

/**
 * CRON job for updating crypto.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class UpdateCryptoJob extends Job
{
  public function getName(): string
  {
    return 'UpdateCrypto';
  }

  public function getInterval(): string
  {
    return '1 HOUR';
  }

  public function process(): void
  {
    // https://polkryptex.lan/cron/run/_SECRET
    $coinApi = new CoinApi('833FC560-3E48-4BAD-ABA9-4A3BE958E6CD');
    // Get info from crypto currencies
  }
}
