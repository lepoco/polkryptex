<?php

namespace App\Core\Data;

use App\Core\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Builds a database
 *
 * @author  Pomianowski <kontakt@rapiddev.pl>
 * @license GPL-3.0 https://www.gnu.org/licenses/gpl-3.0.txt
 * @since   1.1.0
 * @see https://laravel.com/docs/5.0/schema
 * @see https://laravel.com/docs/8.x/queries
 */
final class Schema
{
  public static function build(bool $dropIfExists = false): void
  {
    if ($dropIfExists) {
      self::drop();
    }

    self::tableOptions();
    self::tableUsers();
    self::tableWallets();
    self::tableStatistics();

    self::fill();
  }

  private static function fill(): void
  {
  }

  private static function drop(): void
  {
    /**
     * Drop must be in the correct order regarding the foreign keys.
     */
    DB::schema()->dropIfExists('options');

    DB::schema()->dropIfExists('statistics');
    DB::schema()->dropIfExists('statistics_tags');
    DB::schema()->dropIfExists('statistics_types');

    DB::schema()->dropIfExists('transactions');
    DB::schema()->dropIfExists('wallets');
    DB::schema()->dropIfExists('currencies');

    DB::schema()->dropIfExists('user_billings');
    DB::schema()->dropIfExists('user_newsletters');

    DB::schema()->dropIfExists('users');

    DB::schema()->dropIfExists('user_roles');
    DB::schema()->dropIfExists('user_plans');
  }

  private static function tableOptions(): void
  {
    if (!DB::schema()->hasTable('options')) {
      DB::schema()->create('options', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->longText('value');
        $table->timestamps();
      });
    }
  }

  private static function tableUsers(): void
  {
    if (!DB::schema()->hasTable('user_roles')) {
      DB::schema()->create('user_roles', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('permissions');
        $table->timestamps();
      });
    }

    if (!DB::schema()->hasTable('user_plans')) {
      DB::schema()->create('user_plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('capabilities');
        $table->timestamps();
      });
    }

    if (!DB::schema()->hasTable('users')) {
      DB::schema()->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('email');
        $table->string('name');
        $table->string('display_name');
        $table->string('timezone');
        $table->string('uuid');
        $table->text('location');
        $table->text('image');
        $table->text('password');
        $table->text('session_token');
        $table->text('cookie_token');
        $table->foreignId('plan_id')->references('id')->on('user_plans')->default(1);
        $table->foreignId('role_id')->references('id')->on('user_roles')->default(1);
        $table->timestamp('time_last_login');
        $table->timestamps();
      });
    }

    if (!DB::schema()->hasTable('user_billings')) {
      DB::schema()->create('user_billings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->string('firstname');
        $table->string('lastname');
        $table->string('street');
        $table->string('postal');
        $table->string('city');
        $table->text('phone');
        $table->text('email');
        $table->text('timezone');
        $table->timestamps();
      });
    }

    if (!DB::schema()->hasTable('user_newsletters')) {
      DB::schema()->create('user_newsletters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->string('unsubscribe_token');
        $table->boolean('active')->default(false);
        $table->timestamps();
      });
    }
  }

  private static function tableWallets(): void
  {
    if (!DB::schema()->hasTable('currencies')) {
      DB::schema()->create('currencies', function (Blueprint $table) {
        $table->id();
        $table->string('symbol');
        $table->string('name');
        $table->float('rate')->default(0);
        $table->boolean('is_crypto')->default(false);
        $table->timestamps();
      });
    }

    if (!DB::schema()->hasTable('wallets')) {
      DB::schema()->create('wallets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->foreignId('currency_id')->references('id')->on('currencies')->default(1);
        $table->float('virtual_balance')->default(0);
        $table->timestamps();
      });
    }

    if (!DB::schema()->hasTable('transactions')) {
      DB::schema()->create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->foreignId('wallet_from')->references('id')->on('wallets');
        $table->foreignId('wallet_to')->references('id')->on('wallets');
        $table->float('amount')->default(0);
        $table->string('uuid');
        $table->timestamps();
      });
    }
  }

  private static function tableStatistics(): void
  {
    if (!DB::schema()->hasTable('statistics_tags')) {
      DB::schema()->create('statistics_tags', function (Blueprint $table) {
        $table->id();
        $table->string('name');
      });
    }

    if (!DB::schema()->hasTable('statistics_types')) {
      DB::schema()->create('statistics_types', function (Blueprint $table) {
        $table->id();
        $table->string('name');
      });
    }

    if (!DB::schema()->hasTable('statistics')) {
      DB::schema()->create('statistics', function (Blueprint $table) {
        $table->id();
        $table->foreignId('statistic_tag')->references('id')->on('statistics_tags');
        $table->foreignId('statistic_type')->references('id')->on('statistics_types');
        $table->foreignId('user_id')->nullable()->references('id')->on('users');
        $table->string('ip');
        $table->text('ua');
        $table->timestamps();
      });
    }
  }
}
