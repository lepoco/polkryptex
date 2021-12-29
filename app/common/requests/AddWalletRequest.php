<?php

namespace App\Common\Requests;

use App\Common\Money\{WalletsRepository, CurrenciesRepository, Wallet};
use App\Core\Facades\{Translate, Statistics};
use App\Core\View\Request;
use App\Core\Http\{Status, Redirect};
use App\Core\Auth\Account;

/**
 * Action triggered during adding a wallet.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class AddWalletRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'AddWallet';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'currency',
      'accept_terms',
      'accept_currencies'
    ]);

    $this->isEmpty([
      'id',
      'currency',
      'accept_terms',
      'accept_currencies'
    ]);

    $this->validate([
      ['id', FILTER_VALIDATE_INT],
      ['currency', self::SANITIZE_STRING],
      ['accept_terms', self::SANITIZE_STRING],
      ['accept_currencies', self::SANITIZE_STRING]
    ]);

    $user = Account::current();

    if (empty($user)) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    $currency = CurrenciesRepository::getBy('iso_code', $this->get('currency'));

    if (!$currency->isValid()) {
      $this->finish(self::ERROR_ENTRY_DONT_EXISTS, Status::UNAUTHORIZED);

      return;
    }

    $userWallets = WalletsRepository::getUserWallets($user->getId());

    foreach ($userWallets as $singleWallet) {
      if ($singleWallet->getCurrencyId() === $currency->getId()) {
        $this->addContent('message', Translate::string('You already have a wallet with this currency.'));
        $this->finish(self::ERROR_ENTRY_EXISTS, Status::UNAUTHORIZED);

        break;
      }
    }

    $newWallet = Wallet::build([
      'balance' => 0,
      'user_id' => $user->getId(),
      'currency_id' => $currency->getId()
    ]);

    if (!WalletsRepository::addUserWallet($user->getId(), $newWallet)) {
      $this->addContent('message', Translate::string('There was an error adding a new wallet. Please try again later.'));
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::UNAUTHORIZED);
    }

    Statistics::push(\App\Core\Data\Statistics::TYPE_USER, 'WALLET:Registered');

    $this->addContent('redirect', Redirect::url('dashboard'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
