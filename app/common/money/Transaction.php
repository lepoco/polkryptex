<?php

namespace App\Common\Money;

use App\Common\Money\Currency;
use App\Core\Auth\User;

/**
 * Represents a wallet instance.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class Transaction
{
  private int $id = 0;
}

$table->id();
$table->foreignId('user_id')->references('id')->on('users');
$table->foreignId('wallet_from')->references('id')->on('wallets');
$table->foreignId('wallet_to')->references('id')->on('wallets');
$table->float('amount')->default(0);
$table->boolean('is_topup')->default(false);
$table->string('uuid')->nullable();
$table->timestamp('created_at')->useCurrent();
$table->timestamp('updated_at')->nullable()->useCurrent();