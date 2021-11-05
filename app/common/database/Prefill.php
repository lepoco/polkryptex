<?php

namespace App\Common\Database;

use App\Core\Facades\{Config, Request, DB};

/**
 * Builds a database
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 * @see https://laravel.com/docs/5.0/schema
 * @see https://laravel.com/docs/8.x/queries
 */
final class Prefill
{
  public static function fill(): void
  {
    self::fillOptions();
    self::fillCurrencies();

    // ROLES
    DB::table('user_roles')->insert([
      'name' => 'default',
      'permissions' => '{p:[]}'
    ]);

    DB::table('user_roles')->insert([
      'name' => 'manager',
      'permissions' => '{p:[]}'
    ]);

    DB::table('user_roles')->insert([
      'name' => 'analyst',
      'permissions' => '{p:[]}'
    ]);

    DB::table('user_roles')->insert([
      'name' => 'admin',
      'permissions' => '{p:[\'all\']}'
    ]);

    // PLANS
    DB::table('plans')->insert([
      'name' => 'standard',
      'capabilities' => '{c:[]}'
    ]);

    DB::table('plans')->insert([
      'name' => 'plus',
      'capabilities' => '{c:[]}'
    ]);

    DB::table('plans')->insert([
      'name' => 'premium',
      'capabilities' => '{c:[]}'
    ]);

    DB::table('plans')->insert([
      'name' => 'trader',
      'capabilities' => '{c:[]}'
    ]);

    // DUMMY USER
    DB::table('users')->insert([
      'name' => 'dummy',
      'display_name' => 'dummy',
      'email' => 'dummy@polkryptex.pl',
      'password' => '$cW4yTWs0djAwbTRjTi40VA$lQcuXoa/0y3FNdjrwOtxaJvxJ+GS2WHxAUC1qbk/EQg',
      'role_id' => 1
    ]);
  }

  private static function fillOptions(): void
  {
    DB::table('options')->insert([
      'name' => 'app_version',
      'value' => Config::get('app.version', '1.0.0')
    ]);

    DB::table('options')->insert([
      'name' => 'app_name',
      'value' => Config::get('app.name', 'Polkryptex')
    ]);

    DB::table('options')->insert([
      'name' => 'site_name',
      'value' => Config::get('app.name', 'Polkryptex')
    ]);

    DB::table('options')->insert([
      'name' => 'language',
      'value' => 'en_us'
    ]);

    DB::table('options')->insert([
      'name' => 'base_url',
      'value' => rtrim(Request::root(), '/') . '/'
    ]);

    DB::table('options')->insert([
      'name' => 'home_url',
      'value' => rtrim(Request::root(), '/') . '/'
    ]);

    DB::table('options')->insert([
      'name' => 'signout_time',
      'value' => 15
    ]);

    DB::table('options')->insert([
      'name' => 'cookie_name',
      'value' => 'pkx_cookie'
    ]);

    DB::table('options')->insert([
      'name' => 'service_worker_enabled',
      'value' => 'true'
    ]);

    DB::table('options')->insert([
      'name' => 'stastistics_keep_ip',
      'value' => 'true'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_sendfrom',
      'value' => 'no-reply@example.com'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_replyto',
      'value' => 'smtp@example.com'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_sendname',
      'value' => 'Website'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_legal',
      'value' => 'Website Corporation, Street Name, Redmond, WA 98000 USA'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_smtp_enabled',
      'value' => 'false'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_smtp_auth',
      'value' => 'false'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_smtp_host',
      'value' => 'smtp.example.com'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_smtp_user',
      'value' => 'user@example.com'
    ]);

    DB::table('options')->insert([
      'name' => 'mail_smtp_password',
      'value' => ''
    ]);

    DB::table('options')->insert([
      'name' => 'mail_smtp_port',
      'value' => 465
    ]);
  }

  private static function fillCurrencies(): void
  {
    // REGULAR
    DB::table('currencies')->insert([
      'rate' => 1,
      'iso_number' => 840,
      'iso_code' => 'USD',
      'name' => 'US Dollar',
      'sign' => '$',
      'subunit_sign' => '¢',
      'subunit_name' => 'cent',
      'subunit_multiplier' => 100,
      'is_crypto' => false,
      'is_master' => true,
    ]);

    DB::table('currencies')->insert([
      'rate' => 1.25,
      'iso_number' => 124,
      'iso_code' => 'CAD',
      'name' => 'Canadian Dollar',
      'sign' => '$',
      'subunit_sign' => '¢',
      'subunit_name' => 'cent',
      'subunit_multiplier' => 100,
      'is_crypto' => false,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.86572246,
      'iso_number' => 978,
      'iso_code' => 'EUR',
      'name' => 'Euro',
      'sign' => '€',
      'subunit_sign' => 'c',
      'subunit_name' => 'cent',
      'subunit_multiplier' => 100,
      'is_crypto' => false,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.73666607,
      'iso_number' => 826,
      'iso_code' => 'GBP',
      'name' => 'Pound sterling',
      'sign' => '£',
      'subunit_sign' => 'p',
      'subunit_name' => 'pence',
      'subunit_multiplier' => 100,
      'is_crypto' => false,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 113.89,
      'iso_number' => 392,
      'iso_code' => 'JPY',
      'name' => 'Japanese yen',
      'sign' => '¥',
      'subunit_sign' => '錢',
      'subunit_name' => 'sen',
      'subunit_multiplier' => 100,
      'is_crypto' => false,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 4.00,
      'iso_number' => 985,
      'iso_code' => 'PLN',
      'name' => 'Polish złoty',
      'sign' => 'zł',
      'subunit_sign' => 'gr',
      'subunit_name' => 'groszy',
      'subunit_multiplier' => 100,
      'is_crypto' => false,
      'is_master' => false,
    ]);

    // CRYPTO
    DB::table('currencies')->insert([
      'rate' => 0.000016,
      'iso_number' => 8,
      'iso_code' => 'BTC', // BTC conflicts with ISO 4217, because BT stands for Bhutan.
      'name' => 'Bitcoin',
      'sign' => '₿',
      'subunit_sign' => 's',
      'subunit_name' => 'satoshi',
      'subunit_multiplier' => 100000000,
      'is_crypto' => true,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.0016,
      'iso_number' => 8,
      'iso_code' => 'BCH',
      'name' => 'Bitcoin Cash',
      'sign' => '₿',
      'subunit_sign' => 's',
      'subunit_name' => 'satoshi',
      'subunit_multiplier' => 100000000,
      'is_crypto' => true,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 3.81,
      'iso_number' => 4,
      'iso_code' => 'DOGE',
      'name' => 'Dogecoin',
      'sign' => 'Ð',
      'subunit_sign' => 'ds',
      'subunit_name' => 'dodges',
      'subunit_multiplier' => 100,
      'is_crypto' => true,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.00022,
      'iso_number' => 18,
      'iso_code' => 'ETH', // ETH conflicts with ISO 4217, because ET stands for Ethiopia.
      'name' => 'Ethereum',
      'sign' => 'Ξ',
      'subunit_sign' => 'k',
      'subunit_name' => 'kwei',
      'subunit_multiplier' => 1000,
      'is_crypto' => true,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.0050,
      'iso_number' => 8,
      'iso_code' => 'LTC', // LTC conflicts with ISO 4217, because LT stands for Lithuania.
      'name' => 'Litecoin',
      'sign' => 'Ł',
      'subunit_sign' => 'mł',
      'subunit_name' => 'millilitecoin',
      'subunit_multiplier' => 1000,
      'is_crypto' => true,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.85,
      'iso_number' => 6,
      'iso_code' => 'XRP',
      'name' => 'Ripple',
      'sign' => 'R',
      'subunit_sign' => 'mr',
      'subunit_name' => 'milliripple',
      'subunit_multiplier' => 1000,
      'is_crypto' => true,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.00636,
      'iso_number' => 8,
      'iso_code' => 'ZEC',
      'name' => 'Zcash',
      'sign' => 'Z',
      'subunit_sign' => 'mz',
      'subunit_name' => 'millizash',
      'subunit_multiplier' => 1000,
      'is_crypto' => true,
      'is_master' => false,
    ]);
  }
}
