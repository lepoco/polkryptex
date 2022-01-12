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
    $this->isSet([
      'id',
      'payee_name',
      'wallet',
      'amount'
    ]);

    $this->isEmpty([
      'id',
      'payee_name',
      'wallet',
      'amount'
    ]);

    $this->validate([
      ['id', FILTER_VALIDATE_INT],
      ['wallet', FILTER_VALIDATE_INT],
      ['amount', FILTER_VALIDATE_FLOAT],
      ['payee_name', self::SANITIZE_STRING],
    ]);

    $user = Account::current();
    $amount = (float)$this->get('amount');


    if ($amount < 5 || $amount > 20000) {
      $this->addContent('message', Translate::string('Amount entered is incorrect.'));
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);
    }

    if (empty($user)) {
      $this->addContent('message', Translate::string('Something went wrong, please verify the entered data.'));
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);
    }

    if ((int)trim($this->get('id')) !== $user->getId()) {
      $this->addContent('message', Translate::string('Something went wrong, please verify the entered data.'));
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);
    }

    // Verify wallet
    $userWallets = WalletsRepository::getUserWallets($user->getId());
    $outcomeWallet = null;
    $walletId = (int) $this->get('wallet');

    foreach ($userWallets as $wallet) {
      if ($wallet->getId() == $walletId) {
        $outcomeWallet = $wallet;
      }
    }

    if (empty($outcomeWallet)) {
      $this->addContent('fields', ['wallet']);
      $this->addContent('message', Translate::string('Something went wrong, please verify the entered data.'));
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);
    }

    // Verify payee
    $payee = Account::getBy('name', trim(strtolower($this->get('payee_name'))));

    if (empty($payee)) {
      $this->addContent('fields', ['payee']);
      $this->addContent('message', Translate::string('Something went wrong, please verify the entered data.'));
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);
    }

    $payeeWallets = WalletsRepository::getUserWallets($payee->getId());
    //$payeeCurrencies = array_map(fn ($wallet) => $wallet->getCurrency()->getId(), $userWallets);

    if (empty($payeeWallets)) {
      $this->addContent('fields', ['payee']);
      $this->addContent('message', Translate::string('Your friend doesn\'t have a suitable wallet to transfer money to.'));
      $this->finish(self::ERROR_VALUE_INVALID, Status::UNAUTHORIZED);
    }

    // Validate currency
    $currency = $outcomeWallet->getCurrency()->getId();

    $incomeWallet = null;

    foreach ($payeeWallets as $wallet) {
      if ($wallet->getCurrency()->getId() == $currency) {
        $incomeWallet = $wallet;
      }
    }

    if (empty($incomeWallet)) {
      $incomeWallet = $payeeWallets[0];
    }

    TransactionsRepository::transfer($outcomeWallet, $incomeWallet, $amount);

    $this->addContent('message', Translate::string('Funds successfully transferred.'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
