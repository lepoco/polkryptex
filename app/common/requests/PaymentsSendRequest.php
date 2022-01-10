<?php

namespace App\Common\Requests;

use App\Common\Money\{WalletsRepository, TransactionsRepository, PaymentMethods};
use App\Core\Facades\{Translate, Statistics};
use App\Core\View\Request;
use App\Core\Http\{Status, Redirect};
use App\Core\Auth\Account;

/**
 * Action triggered when sending funds.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class PaymentsSendRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'PaymentsSend';
  }

  public function process(): void
  {
    $this->addContent('message', '{NOT IMPLEMENTED}');
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
