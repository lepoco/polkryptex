<?php

namespace App\Tests\Money;

use DateTime;
use App\Common\Money\Crypto\CoinApi;

beforeEach(function () {
  $apiKey = "";

  $this->coinApi = new CoinApi($apiKey);
});

//Due to limited requests API call are not performed.

// test('Coin API gets list of exchanges.', function () {
//   $requestResponse = $this->coinApi->getExchanges();

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets list of assets.', function () {
//   $requestResponse = $this->coinApi->getAssets();

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets list of symbols.', function () {
//   $requestResponse = $this->coinApi->getSymbols();

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets current exchange rate.', function () {
//   $assetIdBase = 'BTC';
//   $assetIdQuote = 'USD';

//   $requestResponse = $this->coinApi->getExchangeRate($assetIdBase, $assetIdQuote);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets all exchange rates.', function () {
//   $assetIdBase = 'BTC';

//   $requestResponse = $this->coinApi->getExchangeRates($assetIdBase);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets ohlcv periods.', function () {
//   $requestResponse = $this->coinApi->getPeriods();

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API latest ohlcv data for specific symbol and period.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $periodId = '1HRS';
//   $limit = 200;

//   $requestResponse = $this->coinApi->getOHLCVLatest($symbolId, $periodId, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets history ohlcv data for specific symbol, period and time ranges.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $periodId = '1HRS';
//   $limit = 200;
//   $timeStart = (new DateTime())->modify('-7 days');
//   $timeEnd = (new DateTime())->modify('-5 days');

//   $requestResponse = $this->coinApi->getOHLCVHistory($symbolId, $periodId, $timeStart, $timeEnd, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets latest trades across all symbols.', function () {
//   $limit = 200;

//   $requestResponse = $this->coinApi->getTradesLatest('', $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets latest trades from specific symbol.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $limit = 200;

//   $requestResponse = $this->coinApi->getTradesLatest($symbolId, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets history trades from specific symbol and time range.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $limit = 200;
//   $timeStart = (new DateTime())->modify('-7 days');
//   $timeEnd = (new DateTime())->modify('-5 days');

//   $requestResponse = $this->coinApi->getTradesHistory($symbolId, $timeStart, $timeEnd, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets current quotes across all symbols.', function () {
//   $requestResponse = $this->coinApi->getQuotesCurrent();

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets current quote for specific symbol.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';

//   $requestResponse = $this->coinApi->getQuotesCurrent($symbolId);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets latest quotes across all symbols.', function () {
//   $limit = 200;

//   $requestResponse = $this->coinApi->getQuotesLatest('', $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets latest quotes from specific symbol.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $limit = 200;

//   $requestResponse = $this->coinApi->getQuotesLatest($symbolId, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets latest quotes from specific symbol and time range.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $limit = 200;
//   $timeStart = (new DateTime())->modify('-7 days');
//   $timeEnd = (new DateTime())->modify('-5 days');

//   $requestResponse = $this->coinApi->getQuotesHistory($symbolId, $timeStart, $timeEnd, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets current Orderbooks across all symbols.', function () {
//   $requestResponse = $this->coinApi->getOrderbookCurrent();

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets current Orderbooks from specific symbol.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';

//   $requestResponse = $this->coinApi->getOrderbookCurrent($symbolId);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets current Orderbooks from specific symbol.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $limit = 200;

//   $requestResponse = $this->coinApi->getOrderbookCurrent($symbolId, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });

// test('Coin API gets latest quotes from specific symbol and time range.', function () {
//   $symbolId = 'BITSTAMP_SPOT_BTC_USD';
//   $limit = 200;
//   $timeStart = (new DateTime())->modify('-7 days');
//   $timeEnd = (new DateTime())->modify('-5 days');

//   $requestResponse = $this->coinApi->getOrderbookHistory($symbolId, $timeStart, $timeEnd, $limit);

//   $this->assertTrue(!empty($requestResponse));
// });
