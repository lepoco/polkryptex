<?php

namespace App\Common\Cron;

use App\Core\Cron\Job;
use App\Common\Money\Api\OpenExchangeRates;
use App\Common\Money\CurrenciesRepository;
use App\Common\Money\Currency;
use App\Core\Facades\Config;
use App\Core\Facades\Option;

/**
 * CRON job for updating currencies.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class UpdateCurrenciesJob extends Job
{
  private const CORELATIONS = [];

  public function getName(): string
  {
    return 'UpdateCurrencies';
  }

  public function getInterval(): string
  {
    return '1 HOUR';
  }

  public function process(): void
  {
    $openexchangeratesKey = Option::get('openexchangerates_api_key', '');
    $exchangeApi = new OpenExchangeRates($openexchangeratesKey);
    $internalCurrencies = $this->getInternalCurrencies();

    $exchangeApi->fetch();

    foreach ($internalCurrencies as $currency) {
      $this->updateCurrency($currency, $exchangeApi->getRate($currency->getIsoCode()));
    }
  }

  private function updateCurrency(Currency $currency, float $rate): void
  {
    if ($rate <= 0) {
      return;
    }

    if ($currency->getIsoCode() === 'USD') {
      return;
    }

    // ray([
    //   'updating' => $currency->getIsoCode(),
    //   'old_rate' => $currency->getRate(),
    //   'new_rate' => $rate,
    //   'id' => $currency->getId()
    // ]);

    $currency->updateRate($rate);

    CurrenciesRepository::addStock($currency->id(), $rate);
  }

  private function getInternalCurrencies(): array
  {
    return CurrenciesRepository::getAll(['is_crypto' => false]);
  }
}
