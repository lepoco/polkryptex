@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Dashboard')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5">
  <div class="row">
    <div class="col-12  -reveal">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Dashboard')</h4>
    </div>
    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div class="-w-100">
          <h4 class="-reveal"><span class="wallet-current-value">$ {{ number_format($wallets_total, 2) }}</span></h4>

          <div class="floating-input -mt-2 -reveal">
            <select class="floating-input__field" name="select-wallet" style="max-width: 290px"
              placeholder="@translate('Wallet')" name="wallet">

              <option data-sign="$" data-signleft="1" value="{{ number_format($wallets_total, 2) }}">@translate('Total balance')</option>

              @foreach ($wallets as $singleWallet)

              <option data-name="{{ \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}"
                data-sign="{{ $singleWallet->getCurrency()->getSign() }}"
                data-signleft="{{ $singleWallet->getCurrency()->isSignLeft() ? 1 : 0 }}"
                value="{{ number_format($singleWallet->getBalance(), 2) }}">{{
                \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>

              @endforeach

            </select>
            <label style="background: #f3f4f5" for="wallet">@translate('Wallet')</label>
          </div>

          <div class="-reveal">
            <a href="@url('dashboard/exchange')"
              class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('Exchange')</a>
            <a href="@url('dashboard/topup')" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Top up')</a>
            <a href="@url('dashboard/add')" class="btn btn-dark btn-mobile">+</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 -reveal">
      @if($has_transactions ?? false)

      <div class="-w-100 -flex -flex-beetween -mt-4 -mb-3">
        <strong class="-color-secondary">@translate('Recent transations')</strong>
        <a href="@url('dashboard/transactions')">@translate('See all')</a>
      </div>

      @isset($recent_transactions)
      <div class="transactions">
        @foreach ($recent_transactions as $transaction)
        @include('components.transaction', ['transaction' => $transaction])
        @endforeach
      </div>
      @endisset

      @endif
    </div>
  </div>
</div>

@endsection