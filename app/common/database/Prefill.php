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
      'value' => true
    ]);

    DB::table('plans')->insert([
      'name' => 'trader',
      'capabilities' => '{c:[]}'
    ]);

    DB::table('user_roles')->insert([
      'name' => 'default',
      'permissions' => '{p:[]}'
    ]);

    DB::table('user_roles')->insert([
      'name' => 'manager',
      'permissions' => '{p:[]}'
    ]);

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

    DB::table('users')->insert([
      'name' => 'dummy',
      'display_name' => 'dummy',
      'email' => 'dummy@polkryptex.pl',
      'password' => '$cW4yTWs0djAwbTRjTi40VA$lQcuXoa/0y3FNdjrwOtxaJvxJ+GS2WHxAUC1qbk/EQg',
      'role_id' => 1
    ]);

    DB::table('currencies')->insert([
      'rate' => 1,
      'iso_number' => 840,
      'iso_code' => 'USD',
      'name' => 'US Dollar',
      'sign' => '$',
      'decimal_sign' => '¢',
      'decimal_name' => 'cent',
      'is_crypto' => false,
      'is_master' => true,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.86572246,
      'iso_number' => 978,
      'iso_code' => 'EUR',
      'name' => 'Euro',
      'sign' => '€',
      'decimal_sign' => 'c',
      'decimal_name' => 'cent',
      'is_crypto' => false,
      'is_master' => false,
    ]);

    DB::table('currencies')->insert([
      'rate' => 0.73666607,
      'iso_number' => 826,
      'iso_code' => 'GBP',
      'name' => 'Pound sterling',
      'sign' => '£',
      'decimal_sign' => 'p',
      'decimal_name' => 'pence',
      'is_crypto' => false,
      'is_master' => false,
    ]);
  }
}
