@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Add wallet'),
'background' => $base_url . 'img/pexels-photo-259249.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Add wallet')</h2>
<div class="-reveal">
  <form id="addWallet">
    <input type="hidden" name="action" value="AddWallet" />
    <input type="hidden" name="nonce" value="@nonce('addwallet')" />
    <input type="hidden" name="id" value="{{ $user->getId() }}" />

    <div class="floating-input -reveal">
      <select class="floating-input__field" placeholder="@translate('Currency')" name="currency">
        @foreach ($currencies as $singleCurrency)
        <option value="{{ $singleCurrency->getIsoCode() }}">{{ '(' . $singleCurrency->getIsoCode() . ') ' .
          \App\Core\Facades\Translate::string($singleCurrency->getName()) }}</option>
        @endforeach
      </select>
      <label for="currency">@translate('Currency')</label>
    </div>

    <div class="form-check -reveal">
      <input type="checkbox" class="form-check-input" id="accept_terms" name="accept_terms" name="subscribe" value="accept_terms">
      <label for="accept_terms">@translate('I have read and accept the terms and conditions.')</label>
    </div>

    <div class="form-check -reveal -mb-2">
      <input type="checkbox" class="form-check-input" id="accept_currencies" name="accept_currencies" name="subscribe" value="accept_currencies">
      <label for="accept_currencies">@translate('I accept the terms and conditions related to currencies.')</label>
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
      <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Add new wallet')</button>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>
  </form>
</div>
@endsection