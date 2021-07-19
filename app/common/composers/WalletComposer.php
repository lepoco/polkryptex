<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Common\Composers;

use Illuminate\View\View;

/**
 * @author Leszek P.
 */
final class WalletComposer
{
  public function compose(View $view)
  {
    $view->with('wallets', $this->getUserWallets());
  }

  public function getUserWallets()
  {
    return ['hello world'];
  }
}
