<?php

namespace App\Common\Requests;

use App\Common\Money\{WalletsRepository, TransactionsRepository, PaymentMethods};
use App\Core\Facades\{Cache, Translate, Statistics};
use App\Core\View\Request;
use App\Core\Http\{Status, Redirect};
use App\Core\Auth\Account;

/**
 * Action triggered when adding funds.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class TopupRequest extends Request implements \App\Core\Schema\Request
{
  public function getAction(): string
  {
    return 'Topup';
  }

  public function process(): void
  {
    $this->isSet([
      'id',
      'wallet',
      'amount',
      'payment_method'
    ]);

    $this->isEmpty([
      'id',
      'wallet',
      'amount',
      'payment_method'
    ]);

    $this->validate([
      ['id', FILTER_VALIDATE_INT],
      ['wallet', FILTER_VALIDATE_INT],
      ['amount', FILTER_SANITIZE_NUMBER_FLOAT],
      ['payment_method', self::SANITIZE_STRING]
    ]);

    if (1 > $this->get('amount')) {
      $this->addContent('message', Translate::string('Amount entered is too small.'));
      $this->addContent('fields', ['amount']);
      $this->finish(self::ERROR_VALUE_TOO_LOW, Status::OK);
    }

    if (20000 < $this->get('amount')) {
      $this->addContent('message', Translate::string('Amount entered is too big.'));
      $this->addContent('fields', ['amount']);
      $this->finish(self::ERROR_VALUE_TOO_BIG, Status::OK);
    }

    $user = Account::current();

    if (empty($user)) {
      $this->finish(self::ERROR_USER_INVALID, Status::UNAUTHORIZED);

      return;
    }

    $paymentMethod = PaymentMethods::UNKNOWN;

    switch ($this->get('payment_method')) {
      case 'apple_pay':
        $paymentMethod = PaymentMethods::APPLE_PAY;
        break;

      case 'google_pay':
        $paymentMethod = PaymentMethods::GOOGLE_PAY;
        break;

      case 'paypal':
        $paymentMethod = PaymentMethods::PAYPAL;
        break;

      case 'card':
        $paymentMethod = PaymentMethods::CARD;
        break;

      default:
        $this->addContent('message', Translate::string('Incorrect payment method selected.'));
        $this->addContent('fields', ['payment_method']);
        $this->finish(self::ERROR_ENTRY_DONT_EXISTS, Status::OK);

        break;
    }

    $walletBelongs = false;
    /** @var \App\Common\Money\Wallet[] $wallets */
    $wallets = WalletsRepository::getUserWallets($user->getId());
    /** @var \App\Common\Money\Wallet $selectedWallet */
    $selectedWallet = null;

    foreach ($wallets as $wallet) {
      if ($this->get('wallet') == $wallet->getId()) {
        $walletBelongs = true;
        $selectedWallet = $wallet;
      }
    }

    if (!$walletBelongs) {
      $this->addContent('message', Translate::string('Wrong wallet selected.'));
      $this->addContent('fields', ['wallet']);
      $this->finish(self::ERROR_ENTRY_DONT_EXISTS, Status::OK);
    }

    if ($selectedWallet->getCurrency()->isCrypto()) {
      $this->addContent('message', Translate::string('Selected wallet does not support top-ups.'));
      $this->addContent('fields', ['wallet']);
      $this->finish(self::ERROR_ENTRY_DONT_EXISTS, Status::OK);
    }

    // TODO: At this point, we've already verified the correctness of the data and can connect to the payment gateway provider.

    if (!TransactionsRepository::topup($user, $selectedWallet, $this->get('amount'), $paymentMethod)) {
      $this->addContent('message', Translate::string('An error occurred while processing your payment.'));
      $this->finish(self::ERROR_INTERNAL_ERROR, Status::UNAUTHORIZED);
    }

    Statistics::push(\App\Core\Data\Statistics::TYPE_TRANSACTION, 'TRANSACTION:Topup');

    Cache::forget('transactions.list.off0.user_' . $user->getId());

    $this->addContent('redirect', Redirect::url('dashboard'));
    $this->finish(self::CODE_SUCCESS, Status::OK);
  }
}
