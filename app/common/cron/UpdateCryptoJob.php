<?php

namespace App\Common\Cron;

use App\Core\Cron\Job;
use App\Common\Money\Crypto\CoinApi;
use App\Common\Money\CurrenciesRepository;
use App\Common\Money\Currency;
use App\Core\Facades\Config;
use App\Core\Facades\Option;

/**
 * CRON job for updating crypto.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class UpdateCryptoJob extends Job
{
  private const ASSET_CORELATIONS = [
    'BTC' => 'BTC'
  ];

  public function getName(): string
  {
    return 'UpdateCrypto';
  }

  public function getInterval(): string
  {
    return '8 HOURS';
  }

  public function process(): void
  {
    $coinApiKey = Option::get('coin_api_key', '');
    $cryptoCurrencies = $this->getInternalCrypto();
    $coinApi = new CoinApi($coinApiKey);

    $coinApiResponse = $coinApi->getExchangeRates('USD');

    if (!isset($coinApiResponse['rates'])) {
      return;
    }

    foreach ($cryptoCurrencies as $currency) {
      $this->updateCurrency($currency, $this->getRateFromCoinApi($currency->getIsoCode(), $coinApiResponse['rates']));
    }
  }

  private function getRateFromCoinApi(string $currency, array $rates): float
  {
    if (isset(self::ASSET_CORELATIONS[$currency])) {
      $currency = self::ASSET_CORELATIONS[$currency];
    }

    $key = array_search($currency, array_column($rates, 'asset_id_quote'));

    if (!isset($rates[$key])) {
      return 0;
    }

    return $rates[$key]['rate'] ?? 0;
  }

  private function updateCurrency(Currency $currency, float $rate): void
  {
    if ($rate <= 0) {
      return;
    }

    $currency->updateRate($rate);

    CurrenciesRepository::addStock($currency->id(), $rate);
  }

  private function getInternalCrypto(): array
  {
    return CurrenciesRepository::getAll(['is_crypto' => true]);
  }
}
