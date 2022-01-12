@extends('layouts.panel', [
'title' => \App\Core\Facades\Translate::string('Settings')
])

@section('content')

<div class="dashboard container pt-5 pb-5">
  <form id="panelSettings" method="POST">
    <input type="hidden" name="action" value="PanelSettings" />
    <input type="hidden" name="nonce" value="@nonce('panelsettings')" />

    <div class="row">
      <div class="col-12">
        <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Settings')</h4>
      </div>

      <div class="col-12 -mt-1">
        <div class="floating-input -reveal">
          <select class="floating-input__field" placeholder="@translate('Default language')"
            data-selected="@option('language', 'en_US')" name="language">
            <option value="en_US">@translate('English')</option>
            <option value="pl_PL">@translate('Polish')</option>
          </select>
          <label for="language">@translate('Default language')</label>
        </div>
      </div>

      <div class="col-12">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="site_name" placeholder="@translate('Site name')"
            value="@option('site_name', 'Polkryptex')">
          <label for="site_name">@translate('Site name')</label>
        </div>
      </div>

      <div class="col-12 -mb-2 -reveal">
        <hr>
      </div>

      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="base_url" placeholder="@translate('Base URL')"
            value="@option('base_url', '#')">
          <label for="base_url">@translate('Base URL')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="home_url" placeholder="@translate('Home URL')"
            value="@option('home_url', '#')">
          <label for="home_url">@translate('Home URL')</label>
        </div>
      </div>

      <div class="col-12 -mb-2 -reveal">
        <hr>
      </div>

      <div class="col-12">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="number" name="signout_time"
            placeholder="@translate('Signout time')" value="@option('signout_time', 15)">
          <label for="signout_time">@translate('Signout time')</label>
        </div>

        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="cookie_name"
            placeholder="@translate('Privacy cookie name')" value="@option('cookie_name', '#')">
          <label for="cookie_name">@translate('Privacy cookie name')</label>
        </div>
      </div>

      <div class="col-12 -mb-2 -reveal">
        <hr>
      </div>

      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="mail_smtp_host" placeholder="@translate('SMTP Host')"
            value="@option('mail_smtp_host', '')">
          <label for="mail_smtp_host">@translate('SMTP Host')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="email" name="mail_smtp_user" placeholder="@translate('SMTP User')"
            value="@option('mail_smtp_user', '')">
          <label for="mail_smtp_user">@translate('SMTP User')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="password" name="mail_smtp_password"
            placeholder="@translate('SMTP Password')"
            value="{{ empty(\App\Core\Facades\Option::get('mail_smtp_password', '')) ? '' : 'hiddenpasswordhiddenpassword' }}">
          <label for="mail_smtp_password">@translate('SMTP Password')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="number" name="mail_smtp_port" placeholder="@translate('SMTP Port')"
            value="@option('mail_smtp_port', '')">
          <label for="mail_smtp_port">@translate('SMTP Port')</label>
        </div>
      </div>

      <div class="col-12">
        <div class="floating-input -reveal">
          <select class="floating-input__field" placeholder="@translate('SMTP Encryption')"
            data-selected="@option('mail_smtp_encryption', 'en_US')" name="mail_smtp_encryption">
            <option value="smtps">@translate('SMTP SSL')</option>
            <option value="starttls">@translate('START TLS')</option>
          </select>
          <label for="mail_smtp_encryption">@translate('SMTP Encryption')</label>
        </div>
      </div>

      <div class="col-12 -mb-2 -reveal">
        <hr>
      </div>

      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="mail_sendname"
            placeholder="@translate('Name of the email sender')" value="@option('mail_sendname', '')">
          <label for="mail_sendname">@translate('Name of the email sender')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="mail_legal"
            placeholder="@translate('Email legal statement')" value="@option('mail_legal', '')">
          <label for="mail_legal">@translate('Email legal statement')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="email" name="mail_sendfrom"
            placeholder="@translate('Send emails from address')" value="@option('mail_sendfrom', '')">
          <label for="mail_sendfrom">@translate('Send emails from address')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="email" name="mail_replyto"
            placeholder="@translate('Reply-to email address')" value="@option('mail_replyto', '')">
          <label for="mail_replyto">@translate('Reply-to email address')</label>
        </div>
      </div>

      <div class="col-12 -mb-1 -reveal">
        <hr>
      </div>

      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="currencyconverter_api_key" placeholder="@translate('CurrencyConverter API Key')"
            value="@option('currencyconverter_api_key', '')">
          <label for="currencyconverter_api_key">@translate('CurrencyConverter API Key')</label>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="coin_api_key" placeholder="@translate('Coin API Key')"
            value="@option('coin_api_key', '')">
          <label for="coin_api_key">@translate('Coin API Key')</label>
        </div>
      </div>
      <div class="col-12">
        <div class="floating-input -reveal">
          <input class="floating-input__field" type="text" name="openexchangerates_api_key" placeholder="@translate('Open Exchange Rates Key')"
            value="@option('openexchangerates_api_key', '')">
          <label for="openexchangerates_api_key">@translate('Open Exchange Rates Key')</label>
        </div>
      </div>

      <div class="col-12 -mb-1 -reveal">
        <hr>
      </div>

      //redis

      <div class="col-12 -mb-1 -reveal">
        <hr>
      </div>

      <div class="col-12">
        <div class="form-check -reveal">
          <input {{ \App\Core\Facades\Option::get('service_worker_enabled', false) ? 'checked="checked"' : '' }}
            type="checkbox" class="form-check-input" id="service_worker_enabled" name="service_worker_enabled"
            name="service_worker_enabled" value="service_worker_enabled">
          <label for="service_worker_enabled">@translate('Enable Service Worker')</label>
        </div>

        <div class="form-check -reveal">
          <input {{ \App\Core\Facades\Option::get('stastistics_keep_ip', false) ? 'checked="checked"' : '' }}
            type="checkbox" class="form-check-input" id="stastistics_keep_ip" name="stastistics_keep_ip"
            name="stastistics_keep_ip" value="stastistics_keep_ip">
          <label for="stastistics_keep_ip">@translate('Keep IP in statistics')</label>
        </div>

        <div class="form-check -reveal">
          <input {{ \App\Core\Facades\Option::get('mail_smtp_enabled', false) ? 'checked="checked"' : '' }}
            type="checkbox" class="form-check-input" id="mail_smtp_enabled" name="mail_smtp_enabled"
            name="mail_smtp_enabled" value="mail_smtp_enabled">
          <label for="mail_smtp_enabled">@translate('Enable SMTP')</label>
        </div>

        <div class="form-check -reveal -pb-2">
          <input {{ \App\Core\Facades\Option::get('mail_smtp_auth', false) ? 'checked="checked"' : '' }} type="checkbox"
            class="form-check-input" id="mail_smtp_auth" name="mail_smtp_auth" name="mail_smtp_auth"
            value="mail_smtp_auth">
          <label for="mail_smtp_auth">@translate('Enable SMTP Auth')</label>
        </div>

        <div class="form-check -reveal -pb-2">
          <input {{ \App\Core\Facades\Option::get('cron_run_by_user', false) ? 'checked="checked"' : '' }} type="checkbox"
            class="form-check-input" id="cron_run_by_user" name="cron_run_by_user" name="cron_run_by_user"
            value="cron_run_by_user">
          <label for="cron_run_by_user">@translate('Trigger CRON jobs by user visit.')</label>
        </div>
      </div>

      <div class="col-12 -reveal">
        <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1 -reveal">@translate('Update')</button>
      </div>

    </div>
  </form>
</div>

@endsection