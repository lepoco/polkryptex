@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Request transfer')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5 -reveal">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Request transfer')</h4>
    </div>
    <div class="col-12">
      <form id="paymentsRequest">
        <input type="hidden" name="action" value="PaymentsRequest" />
        <input type="hidden" name="nonce" value="@nonce('paymentsrequest')" />
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
          <input class="floating-input__field" type="number" min="5" max="1000" name="amount"
            placeholder="@translate('Amount')" value="@option('amount', '')">
          <label for="amount">@translate('Amount')</label>
        </div>

        <div class="floating-search -reveal">
          <select data-placeholder="Search 123" name="payee">
            <option disabled readonly selected>Select user</option>
            <option value="1">First option</option>
            <option value="2">Second option</option>
            <option value="3">Third option</option>
            <option value="4">Fourth option</option>
            <option value="5">Fifth option</option>
            <option value="6">Sixth option</option>
          </select>
          <label for="payee">@translate('Payee')</label>
        </div>

        <div class="-reveal -pb-1">
          <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Request')</button>
          <a href="@url('dashboard/payments')" class="btn btn-outline-dark btn-mobile">@translate('Back to payments')</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection