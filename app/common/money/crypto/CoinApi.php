<?php

namespace App\Common\Money\Crypto;

use InvalidArgumentException;
use DateTime;
use App\Common\Money\Crypto\CoinApiClient;

/**
 * Provides methods for retrieving information from the Coin API.
 *
 * @author  Sroka <sroka@polkryptex.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.2.0
 */
final class CoinApi
{
  /** Best possible HTTP client for the API. */
  private CoinApiClient $apiClient;

  public function __construct(string $apiKey)
  {
    $this->apiClient = new CoinApiClient($apiKey);
  }

  /**
   * Gets list of exchanges.
   */
  public function getExchanges(): array
  {
    return $this->apiClient->request('exchanges');
  }

  /**
   * Gets list of assets.
   */
  public function getAssets(): array
  {
    return $this->apiClient->request('assets');
  }

  /**
   * Gets list of symbols.
   */
  public function getSymbols(): array
  {
    return $this->apiClient->request('symbols');
  }

  /**
   * Gets list of OHLCV periods.
   */
  public function getPeriods(): array
  {
    return $this->apiClient->request('ohlcv/periods');
  }

  /**
   * Gets all exchange rates for given asset.
   */
  public function getExchangeRates(string $baseAssetId): array
  {
    if (empty($baseAssetId)) {
      throw new InvalidArgumentException("baseAssetId is required");
    }

    return $this->apiClient->request('exchangerate/' . $baseAssetId);
  }

  /**
   * Gets exchange rate for given asset.
   */
  public function getExchangeRate(string $baseAssetId, string $quoteAssetId, string $time = ''): array
  {
    if (empty($baseAssetId)) {
      throw new InvalidArgumentException("baseAssetId is required");
    }

    if (empty($quoteAssetId)) {
      throw new InvalidArgumentException("quoteAssetId is required");
    }

    if (empty($time)) {
      return $this->apiClient->request('exchangerate/' . $baseAssetId . '/' . $quoteAssetId);
    }

    return $this->apiClient->request('exchangerate/' . $baseAssetId . '/' . $quoteAssetId . '?time=' . $time);
  }

  /**
   * Gets latest OHLCV.
   */
  public function getOHLCVLatest(string $symbolId, string $periodId, int $limit = 0): array
  {
    if (empty($symbolId)) {
      throw new InvalidArgumentException("symbolId is required");
    }

    if (empty($periodId)) {
      throw new InvalidArgumentException("periodId is required");
    }

    if ($limit === 0) {
      return $this->apiClient->request('ohlcv/' . $symbolId . '/latest?periodId=' . $periodId);
    }

    return $this->apiClient->request('ohlcv/' . $symbolId . '/latest?periodId=' . $periodId . '&limit=' . $limit);
  }

  /**
   * Gets OHLCV history.
   */
  public function getOHLCVHistory(string $symbolId, string $periodId, DateTime $timeStart, ?DateTime $timeEnd = null, int $limit = 0): array
  {
    if (empty($symbolId)) {
      throw new InvalidArgumentException("symbolId is required");
    }

    if (empty($periodId)) {
      throw new InvalidArgumentException("periodId is required");
    }

    if (empty($timeStart)) {
      throw new InvalidArgumentException("periodId is required");
    }

    $timeStart = $this->formatDateTime($timeStart);

    if (empty($timeEnd) && $limit > 0) {
      return $this->apiClient->request('ohlcv/' . $symbolId . '/history?periodId=' . $periodId . '&timeStart=' . $timeStart . '&limit=' . $limit);
    }

    if (empty($timeEnd) && $limit === 0) {
      return $this->apiClient->request('ohlcv/' . $symbolId . '/history?periodId=' . $periodId . '&timeStart=' . $timeStart);
    }

    $timeEnd = $this->formatDateTime($timeEnd);

    if ($limit === 0) {
      return $this->apiClient->request('ohlcv/' . $symbolId . '/history?periodId=' . $periodId . '&timeStart=' . $timeStart . '&timeEnd=' . $timeEnd);
    }

    return $this->apiClient->request('ohlcv/' . $symbolId . '/history?periodId=' . $periodId . '&timeStart=' . $timeStart . '&timeEnd=' . $timeEnd . '&limit=' . $limit);
  }

  /**
   * Gets list of latest trades.
   */
  public function getTradesLatest(string $symbolId = '', int $limit = 0): array
  {
    if (empty($symbolId) && $limit === 0) {
      return $this->apiClient->request('trades/latest');
    }

    if (empty($symbolId) && $limit > 0) {
      return $this->apiClient->request('trades/latest?limit=' . $limit);
    }

    if ($limit === 0) {
      return $this->apiClient->request('trades/' . $symbolId . '/latest');
    }

    return $this->apiClient->request('trades/' . $symbolId . '/latest?limit=' . $limit);
  }

  /**
   * Gets history of trades for selected symbol.
   */
  public function getTradesHistory(string $symbolId, DateTime $timeStart, ?DateTime $timeEnd = null, int $limit = 0)
  {
    if (empty($symbolId)) {
      throw new InvalidArgumentException("symbolId is required");
    }

    if (empty($timeStart)) {
      throw new InvalidArgumentException("timeStart is required");
    }

    $timeStart = $this->formatDateTime($timeStart);

    if (empty($timeEnd) && $limit === 0) {
      return $this->apiClient->request('trades/' . $symbolId . '/history?timeStart=' . $timeStart);
    }

    if (empty($timeEnd) && $limit > 0) {
      return $this->apiClient->request('trades/' . $symbolId . '/history?timeStart=' . $timeStart . '&limit=' . $limit);
    }

    $timeEnd = $this->formatDateTime($timeEnd);

    if ($limit === 0) {
      return $this->apiClient->request('trades/' . $symbolId . '/history?timeStart=' . $timeStart . '&timeEnd=' . $timeEnd);
    }

    return $this->apiClient->request('trades/' . $symbolId . '/history?timeStart=' . $timeStart . '&timeEnd=' . $timeEnd . '&limit=' . $limit);
  }

  /**
   * Gets quotes for selected symbol.
   */
  public function getQuotesCurrent(string $symbolId = '')
  {
    if (empty($symbolId)) {
      return $this->apiClient->request('quotes/current');
    }

    return $this->apiClient->request('quotes/' . $symbolId . '/current');
  }

  /**
   * Gets limited list of latest quotes for selected symbol.
   */
  public function getQuotesLatest(string $symbolId = '', int $limit = 0)
  {
    if (empty($symbolId) && $limit === 0) {
      return $this->apiClient->request('quotes/latest');
    }

    if (empty($symbolId) && $limit > 0) {
      return $this->apiClient->request('quotes/latest?limit=' . $limit);
    }

    if ($limit === 0) {
      return $this->apiClient->request('quotes/' . $symbolId . '/latest');
    }

    return $this->apiClient->request('quotes/' . $symbolId . '/latest?limit=' . $limit);
  }

  /**
   * Gets historical data for selected symbol.
   */
  public function getQuotesHistory(string $symbolId, DateTime $timeStart, ?DateTime $timeEnd = null, int $limit = 0)
  {
    if (empty($symbolId)) {
      throw new InvalidArgumentException("symbolId is required");
    }

    if (empty($timeStart)) {
      throw new InvalidArgumentException("timeStart is required");
    }

    $timeStart = $this->formatDateTime($timeStart);

    if (empty($timeEnd) && $limit === 0) {
      return $this->apiClient->request('quotes/' . $symbolId . '/history?timeStart=' . $timeStart);
    }

    if (empty($timeEnd) && $limit > 0) {
      return $this->apiClient->request('quotes/' . $symbolId . '/history?timeStart=' . $timeStart . '&limit=' . $limit);
    }

    $timeEnd = $this->formatDateTime($timeEnd);

    if ($limit === 0) {
      return $this->apiClient->request('quotes/' . $symbolId . '/history?timeStart=' . $timeStart . '&timeEnd=' . $timeEnd);
    }

    return $this->apiClient->request('quotes/' . $symbolId . '/history?timeStart=' . $timeStart . '&timeEnd=' . $timeEnd . '&limit=' . $limit);
  }

  /**
   * Gets order book for selected symbol.
   */
  public function getOrderbookCurrent(string $symbolId = '')
  {
    if (empty($symbolId)) {
      return $this->apiClient->request('orderbooks/current');
    }

    return $this->apiClient->request('orderbooks/' . $symbolId . '/current');
  }

  /**
   * Gets latest order book for selected symbol.
   */
  public function getOrderbookLatest(string $symbolId, int $limit = 0)
  {
    if (empty($symbolId)) {
      throw new InvalidArgumentException("symbolId is required");
    }

    if ($limit === 0) {
      return $this->apiClient->request('orderbooks/' . $symbolId . '/latest');
    }

    return $this->apiClient->request('orderbooks/' . $symbolId . '/latest?limit=' . $limit);
  }

  /**
   * Gets orderbook history for selected symbol.
   */
  public function getOrderbookHistory(string $symbolId, DateTime $timeStart, ?DateTime $timeEnd = null, int $limit = 0)
  {
    if (empty($symbolId)) {
      throw new InvalidArgumentException("symbolId is required");
    }

    if (empty($timeStart)) {
      throw new InvalidArgumentException("timeStart is required");
    }

    $timeStart = $this->formatDateTime($timeStart);

    if (empty($timeEnd) && $limit === 0) {
      return $this->apiClient->request('orderbooks/' . $symbolId . '/history?timeStart=' . $timeStart);
    }

    if (empty($timeEnd) && $limit > 0) {
      return $this->apiClient->request('orderbooks/' . $symbolId . '/history?timeStart=' . $timeStart . '&limit=' . $limit);
    }

    $timeEnd = $this->formatDateTime($timeEnd);

    if ($limit === 0) {
      return $this->apiClient->request('orderbooks/' . $symbolId . '/history?timeStart=' . $timeStart . '&timeEnd=' . $timeEnd);
    }

    return $this->apiClient->request('orderbooks/' . $symbolId . '/history?timeStart=' . $timeStart . '&timeEnd=' . $timeEnd . '&limit=' . $limit);
  }

  /**
   * Formats DateTime object according to API requirements.
   */
  public function formatDateTime(DateTime $dateTime)
  {
    return str_replace(' ', 'T', $dateTime->format('Y-m-d H:i:s.u')) . '0Z';
  }
}
