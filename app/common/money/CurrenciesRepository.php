<?php

namespace App\Common\Money;

use App\Core\Facades\{DB, Cache};

/**
 * Contains the logic responsible for managing the currencies.
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 */
final class CurrenciesRepository
{
  /**
   * Retrieves all currencies from the database.
   */
  public static function getAll(): array
  {
    $currencies = [];
    $dbCurrencies = DB::table('currencies')->get()->all();

    foreach ($dbCurrencies as $currency) {
      if (!isset($currency->id) || !isset($currency->rate) || !isset($currency->name)) {
        continue;
      }

      $currencies[] = self::fetchFromObject($currency);
    }

    return $currencies;
  }

  public static function getBy(string $key, string $value): Currency
  {
    $currencyId = Cache::remember('currency.getby.' . $key . '_' . $value, function () use ($key, $value) {
      $query = DB::table('currencies')->where($key, 'LIKE', $value)->get(['id'])->first();

      if (!isset($query->id)) {
        return 0;
      }

      return $query->id;
    });

    return new Currency($currencyId);
  }

  private static function fetchFromObject(object $db): Currency
  {
    return Currency::build([
      'id' => $db->id ?? 0,
      'rate' => $db->rate ?? 1,
      'iso_number' => $db->iso_number ?? 0,
      'iso_code' => $db->iso_code,
      'sign' => $db->sign,
      'name' => $db->name,
      'subunit_sign' => $db->subunit_sign,
      'subunit_name' => $db->subunit_name,
      'subunit_multiplier' => $db->subunit_multiplier ?? 100,
      'is_crypto' => $db->is_crypto ?? false,
      'is_master' => $db->is_master ?? false,
      'created_at' => $db->created_at ?? date('Y-m-d H:i:s'),
      'updated_at' => $db->updated_at ?? date('Y-m-d H:i:s')
    ]);
  }
}
