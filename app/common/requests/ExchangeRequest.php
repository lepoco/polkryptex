<?php

namespace App\Common\Requests;

use App\Common\Money\TransactionsRepository;
use App\Common\Money\WalletsRepository;
use App\Core\Facades\{Email, Translate, Session};
use App\Core\View\Request;
use App\Core\Http\{Status, Redirect};
use App\Core\Auth\{Account, User, Permission, Confirmation};
use App\Core\Data\Encryption;
use App\Core\Utils\Cast;
use Illuminate\Support\Str;

/**
 * Action triggered during money exchange.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class ExchangeRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'Exchange';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'wallet_from',
      'wallet_to',
      'amount',
      'accept_terms'
    ]);

    $this->isEmpty([
      'id',
      'wallet_from',
      'wallet_to',
      'amount',
      'accept_terms'
    ]);

    $this->validate([
      ['id', FILTER_SANITIZE_NUMBER_INT],
      ['wallet_from', self::SANITIZE_STRING],
      ['wallet_to', self::SANITIZE_STRING],
      ['amount', FILTER_SANITIZE_NUMBER_FLOAT],
      ['wallet_to', self::SANITIZE_STRING],
    ]);

    $user = Account::current();

    if (empty($user)) {
      $this->addContent('message', Translate::string('There was an error exchange. Please try again later.'));
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::UNAUTHORIZED);
    }

    if ($user->id() !== (int)$this->get('id')) {
      $this->addContent('message', Translate::string('There was an error exchange. Please try again later.'));
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::UNAUTHORIZED);
    }

    $wallets = WalletsRepository::getUserWallets($user->id());

    $outcomeWallet = null;
    $incomeWallet = null;

    foreach ($wallets as $singleWallet) {
      if ($singleWallet->getCurrency()->getIsoCode() == $this->get('wallet_from')) {
        $outcomeWallet = $singleWallet;
      }
      if ($singleWallet->getCurrency()->getIsoCode() == $this->get('wallet_to')) {
        $incomeWallet = $singleWallet;
      }
    }

    if (empty($outcomeWallet) || empty($incomeWallet)) {
      $this->addContent('message', Translate::string('There was an error exchange. Please try again later.'));
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::UNAUTHORIZED);
    }

    if ($outcomeWallet->getBalance() < (float)$this->get('amount')) {
      $this->addContent('message', Translate::string('You do not have sufficient funds in your account.'));
      $this->finish(self::ERROR_VALUE_TOO_LOW, Status::UNAUTHORIZED);
    }

    TransactionsRepository::exchange($outcomeWallet, $incomeWallet, (float)$this->get('amount'));

    $this->addContent('redirect', Redirect::url('dashboard'));
    $this->addContent('message', Translate::string('Funds successfully exchanged.'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
