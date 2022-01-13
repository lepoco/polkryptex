@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Exchange'),
'background' => $base_url . 'img/pexels-person-holding-bitcoin.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Exchange')</h2>
<div>
  @if(!$has_one_wallet)

  <form id="exchange">
    <input type="hidden" name="action" value="Exchange" />
    <input type="hidden" name="nonce" value="@nonce('exchange')" />
    <input type="hidden" name="id" value="{{ $user->id() ?? '0' }}" />

    <div class="floating-input -reveal">
      <select class="floating-input__field" placeholder="@translate('From wallet')" name="wallet_from">
        @foreach ($user_wallets as $singleWallet)
        <option data-crypto="{{ $singleWallet->getCurrency()->isCrypto() ? '1' : '0' }}" data-rate="{{ $singleWallet->getCurrency()->getRate() }}" value="{{ $singleWallet->getCurrency()->getIsoCode() }}">{{ $singleWallet->getCurrency()->getIsoCode() . ' - ' .
          \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>
        @endforeach
      </select>
      <label for="wallet_from">@translate('From wallet')</label>
    </div>

    <div class="floating-input -reveal">
      <select class="floating-input__field" placeholder="@translate('To wallet')" name="wallet_to">
        @php $count = 0; @endphp
        @foreach ($user_wallets as $singleWallet)
        <option data-crypto="{{ $singleWallet->getCurrency()->isCrypto() ? '1' : '0' }}" {{ $count++ > 0 ? 'selected="selected"' : ''}} data-rate="{{ $singleWallet->getCurrency()->getRate() }}" value="{{ $singleWallet->getCurrency()->getIsoCode() }}">{{ $singleWallet->getCurrency()->getIsoCode() . ' - ' .
          \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>
        @endforeach
      </select>
      <label for="wallet_to">@translate('To wallet')</label>
    </div>

    <div class="floating-input -reveal">
      <input class="floating-input__field" type="number" placeholder="@translate('Amount')" name="amount" min="5" max="20000">
      <label for="amount">@translate('Amount')</label>
    </div>

    <div class="-mb-2 -reveal">
      <p class="-font-secondary -fw-700">@translate('Exchange rate'):</p>
      <h4 class="exchange-rate">0</h4>
      <p class="-font-secondary -fw-700">@translate('Exchanged'):</p>
      <h4 class="exchanged-amount">0</h4>
    </div>

    <div class="form-check -mb-2 -reveal">
      <input type="checkbox" class="form-check-input" id="accept_terms" name="accept_terms" name="subscribe" value="accept_terms">
      <label for="accept_terms">@translate('I have read and accept the terms and conditions.')</label>
    </div>

    <div class="-mb-2 -reveal">
      <div class="-flex">
        <span class="-mr-1"><i class="icon-filled-ic_fluent_shield_error_20 -s-16"></i></span>
        <strong style="line-height: 2.8rem;">@translate('Capital at risk')</strong>
      </div>
      <small>
        This stock trading platform is facilitated by Polkryptex Trading. Neither Polkryptex nor Polkryptex Trading provides
        investment advice and individual investors should make their own decisions or seek professional independent
        advice if they are unsure as to the suitability/appropriateness of any investment for their individual circumstances or needs.
        Currency rate fluctuations can adversely impact the overall returns on your original investment.
      </small>
    </div>

    <div class="-reveal -pb-1">
      <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Exchange currencies')</button>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>
  </form>
  @else
    <div class="-reveal">
      <p>@translate('You currently only have one wallet, add a new one to be able to exchange currencies between them.')</p>
      <a href="@url('dashboard/add')" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Add new wallet')</a>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>
  @endif
</div>
@endsection