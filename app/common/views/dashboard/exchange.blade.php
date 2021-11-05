@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Exchange'),
'background' => $base_url . 'img/pexels-person-holding-bitcoin.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Exchange')</h2>
<div>
  <form id="exchange">
    <input type="hidden" name="action" value="Exchange" />
    <input type="hidden" name="nonce" value="@nonce('exchange')" />

    <div class="floating-input -reveal">
      <select class="floating-input__field" placeholder="@translate('From wallet')" name="wallet_from">
        @foreach ($user_wallets as $singleWallet)
        <option value="{{ $singleWallet->getCurrency()->getIsoCode() }}">{{ $singleWallet->getCurrency()->getIsoCode() . ' - ' .
          \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>
        @endforeach
      </select>
      <label for="wallet_from">@translate('From wallet')</label>
    </div>

    <div class="floating-input -reveal">
      <select class="floating-input__field" placeholder="@translate('To wallet')" name="wallet_to">
        @foreach ($user_wallets as $singleWallet)
        <option value="{{ $singleWallet->getCurrency()->getIsoCode() }}">{{ $singleWallet->getCurrency()->getIsoCode() . ' - ' .
          \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>
        @endforeach
      </select>
      <label for="wallet_to">@translate('To wallet')</label>
    </div>

    <div class="floating-input">
      <input class="floating-input__field" type="number" placeholder="@translate('Amount')" name="amount">
      <label for="amount">@translate('Amount')</label>
    </div>

    <div class="-reveal -pb-1">
      <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Exchange currencies')</button>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>
  </form>
</div>
@endsection