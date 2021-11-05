@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Top up'),
'background' => $base_url . 'img/pexels-photo-6347707.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Top up')</h2>
<div>
  <form id="topup">
    <input type="hidden" name="action" value="Topup" />
    <input type="hidden" name="nonce" value="@nonce('topup')" />
    <input type="hidden" name="id" value="{{ $user->getId() }}" />

    <div class="floating-input -reveal">
      <select class="floating-input__field" placeholder="@translate('Currency')" name="wallet">
        @foreach ($user_wallets as $singleWallet)
        <option value="{{ $singleWallet->getId() }}">{{ $singleWallet->getCurrency()->getIsoCode() . ' - ' .
          \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>
        @endforeach
      </select>
      <label for="wallet">@translate('Currency')</label>
    </div>

    <div class="floating-input -reveal">
      <input class="floating-input__field" type="number" placeholder="@translate('Amount')" name="amount">
      <label for="amount">@translate('Amount')</label>
    </div>

    <div class="-mt-1 -mb-2">
      <hr>
    </div>

    <div class="floating-radio -split">
      <label>
        <input type="radio" name="payment_method" checked="checked" />
          <div class="floating-radio__label -reveal">
            @media('apple-pay.svg')
          </div>
      </label>

      <label>
        <input type="radio" name="payment_method" />
          <div class="floating-radio__label -reveal">
            @media('google-pay.svg')
          </div>
      </label>

      <label>
        <input type="radio" name="payment_method" />
          <div class="floating-radio__label -reveal">
            @media('paypal.svg')
          </div>
      </label>

      <label>
        <input type="radio" name="payment_method" />
          <div class="floating-radio__label -reveal">
            @media('mastercard-horizontal.svg')
          </div>
      </label>
    </div>

    <div class="-reveal -pb-1">
      <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Top up')</button>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>
  </form>
</div>
@endsection