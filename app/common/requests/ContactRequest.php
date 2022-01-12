<?php

namespace App\Common\Requests;

use App\Core\View\Request;
use App\Core\Http\Status;
use App\Core\Auth\Account;

/**
 * Action triggered during signing in.
 *
 * @author  Kujawski <szymon@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class ContactRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'Contact';
  }

  public function process(): void
  {
    $this->addContent('message', '{NOT IMPLEMENTED}');
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
