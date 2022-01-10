<?php

namespace App\Common\Money\Api;

use App\Common\Money\Api\OpenExchangeRatesClient;
use LogicException;

/**
 * Provides methods for retrieving information from the Open Exchange Rates API.
 *
 * @author  Pomianowski <support@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.2.0
 */
final class OpenExchangeRates
{
  /** Best possible HTTP client for the API. */
  private OpenExchangeRatesClient $apiClient;

  private bool $fetched = false;

  private array $rates = [];

  public function __construct(string $apiKey)
  {
    $this->apiClient = new OpenExchangeRatesClient($apiKey);
  }

  public function fetch(): bool
  {
    $allCurrencies = $this->getAll();
    $this->fetched = true;

    if (!isset($allCurrencies['rates'])) {
      return false;
    }

    $this->rates = $allCurrencies['rates'];

    return true;
  }

  public function getRate(string $currencyIsoCode): float
  {
    if (!$this->fetched) {
      throw new LogicException("Could not get exchange rate if Fetch command was not executed.");
    }

    $currencyIsoCode = trim(strtoupper($currencyIsoCode));

    return $this->rates[$currencyIsoCode] ?? 0;
  }

  /**
   * Gets list of exchanges.
   */
  public function getAll(): array
  {
    return $this->apiClient->request('latest.json');
  }
}
