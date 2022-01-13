<?php

namespace App\Common\Database;

use App\Core\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * Builds a database.
 *
 * @author  Pomianowski <support@polkryptex.pl>
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
    self::tableCron();
    self::tableUsers();
    self::tableWallets();
    self::tableStatistics();
  }

  private static function drop(): void
  {
    /**
     * Drop must be in the correct order regarding the foreign keys.
     */
    DB::schema()->dropIfExists('options');
    DB::schema()->dropIfExists('cron');

    DB::schema()->dropIfExists('statistics');
    DB::schema()->dropIfExists('statistics_tags');
    DB::schema()->dropIfExists('statistics_types');
    DB::schema()->dropIfExists('statistics_ips');

    DB::schema()->dropIfExists('transactions');
    DB::schema()->dropIfExists('transaction_type');
    DB::schema()->dropIfExists('transaction_method');

    DB::schema()->dropIfExists('wallets');
    DB::schema()->dropIfExists('currencies_stock');
    DB::schema()->dropIfExists('currencies');

    DB::schema()->dropIfExists('user_billings');
    DB::schema()->dropIfExists('user_newsletters');
    DB::schema()->dropIfExists('user_plans');
    DB::schema()->dropIfExists('user_confirmations');

    DB::schema()->dropIfExists('user_cards');
    DB::schema()->dropIfExists('user_keys');

    DB::schema()->dropIfExists('users');

    DB::schema()->dropIfExists('user_roles');
    DB::schema()->dropIfExists('plans');
    DB::schema()->dropIfExists('confirmation_types');
  }

  private static function tableOptions(): void
  {
    if (!DB::schema()->hasTable('options')) {
      DB::schema()->create('options', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->longText('value')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }
  }

  private static function tableCron(): void
  {
    if (!DB::schema()->hasTable('cron')) {
      DB::schema()->create('cron', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamp('last_run')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
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
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('plans')) {
      DB::schema()->create('plans', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('capabilities');
        $table->integer('tier')->nullable();
        $table->boolean('default')->default(false);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('confirmation_types')) {
      DB::schema()->create('confirmation_types', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamp('created_at')->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('users')) {
      DB::schema()->create('users', function (Blueprint $table) {
        $table->id();
        $table->string('email');
        $table->string('name');
        $table->string('display_name')->nullable();
        $table->string('uuid')->nullable();
        $table->text('image')->nullable();
        $table->text('password')->nullable();
        $table->text('session_token')->nullable();
        $table->text('cookie_token')->nullable();
        $table->foreignId('role_id')->references('id')->on('user_roles');
        $table->string('language')->default('en_US');
        $table->string('timezone')->nullable()->default('UTC');
        $table->timestamp('time_last_login')->nullable();
        $table->boolean('is_active')->default(false);
        $table->boolean('is_confirmed')->default(false);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('user_plans')) {
      DB::schema()->create('user_plans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->foreignId('plan_id')->references('id')->on('plans');
        $table->timestamp('expires_at')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('user_confirmations')) {
      DB::schema()->create('user_confirmations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->foreignId('confirmation_id')->references('id')->on('confirmation_types');
        $table->text('token')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->boolean('is_confirmed')->default(false);
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('user_keys')) {
      DB::schema()->create('user_keys', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->text('name')->nullable();
        $table->text('key')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('user_cards')) {
      DB::schema()->create('user_cards', function (Blueprint $table) {
        $table->id();
        $table->foreignId('key_id')->references('id')->on('user_keys');
        $table->foreignId('user_id')->references('id')->on('users');
        $table->text('number')->nullable();
        $table->text('holder')->nullable();
        $table->text('expiration')->nullable();
        $table->text('security')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('user_billings')) {
      DB::schema()->create('user_billings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('street')->nullable();
        $table->string('postal')->nullable();
        $table->string('city')->nullable();
        $table->string('country')->nullable();
        $table->string('province')->nullable();
        $table->text('phone')->nullable();
        $table->text('email')->nullable();
        $table->text('timezone')->nullable();
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('user_newsletters')) {
      DB::schema()->create('user_newsletters', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->string('unsubscribe_token');
        $table->boolean('active')->default(false);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }
  }

  private static function tableWallets(): void
  {
    // https://en.wikipedia.org/wiki/ISO_4217
    if (!DB::schema()->hasTable('currencies')) {
      DB::schema()->create('currencies', function (Blueprint $table) {
        $table->id();
        $table->float('rate', 32, 16, false)->default(1);
        $table->integer('iso_number')->nullable();
        $table->string('iso_code')->nullable();
        $table->string('sign')->nullable();
        $table->string('name')->nullable();
        $table->boolean('sign_left')->default(true);
        $table->string('subunit_sign')->nullable();
        $table->string('subunit_name')->nullable();
        $table->integer('subunit_multiplier')->nullable()->default(100);
        $table->boolean('is_crypto')->default(false);
        $table->boolean('is_master')->default(false);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('currencies_stock')) {
      DB::schema()->create('currencies_stock', function (Blueprint $table) {
        $table->id();
        $table->float('rate', 32, 16, false)->default(1);
        $table->foreignId('currency_id')->references('id')->on('currencies')->default(1);
        $table->timestamp('created_at')->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('wallets')) {
      DB::schema()->create('wallets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->foreignId('currency_id')->references('id')->on('currencies')->default(1);
        $table->float('virtual_balance', 32, 16, false)->default(0);
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrent();
      });
    }

    if (!DB::schema()->hasTable('transaction_type')) {
      DB::schema()->create('transaction_type', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
      });
    }

    if (!DB::schema()->hasTable('transaction_method')) {
      DB::schema()->create('transaction_method', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
      });
    }

    if (!DB::schema()->hasTable('transactions')) {
      DB::schema()->create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->references('id')->on('users');
        $table->foreignId('wallet_from')->nullable()->references('id')->on('wallets');
        $table->foreignId('wallet_to')->references('id')->on('wallets');
        $table->float('amount', 32, 16, false)->default(0);
        $table->float('rate', 32, 16, false)->default(1);
        $table->boolean('is_topup')->default(false);
        $table->string('uuid')->nullable();
        $table->string('method_reference')->nullable();
        $table->foreignId('method_id')->references('id')->on('transaction_method')->default(1);
        $table->foreignId('type_id')->references('id')->on('transaction_type')->default(1);
        $table->timestamp('created_at')->useCurrent();
      });
    }
  }

  private static function tableStatistics(): void
  {
    if (!DB::schema()->hasTable('statistics_ips')) {
      DB::schema()->create('statistics_ips', function (Blueprint $table) {
        $table->id();
        $table->string('ip')->nullable();
      });
    }

    if (!DB::schema()->hasTable('statistics_tags')) {
      DB::schema()->create('statistics_tags', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
      });
    }

    if (!DB::schema()->hasTable('statistics_types')) {
      DB::schema()->create('statistics_types', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
      });
    }

    if (!DB::schema()->hasTable('statistics')) {
      DB::schema()->create('statistics', function (Blueprint $table) {
        $table->id();
        $table->foreignId('statistic_tag')->references('id')->on('statistics_tags');
        $table->foreignId('statistic_type')->references('id')->on('statistics_types');
        $table->foreignId('user_id')->nullable()->references('id')->on('users');
        $table->foreignId('ip_id')->nullable()->references('id')->on('statistics_ips');
        $table->text('ua')->nullable();
        $table->timestamp('created_at')->useCurrent();
      });
    }
  }
}
