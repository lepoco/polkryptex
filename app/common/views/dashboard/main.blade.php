@extends('layouts.app', [
'title' => 'Dashboard'
])
@section('content')

<div class="dashboard container pt-5 pb-5 -mb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Dashboard')</h4>
    </div>
    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div class="-w-100">
          <h4>$3213,33</h4>
          <p>US Dollar</p>

          <a href="@url('dashboard/exchange')" class="btn btn-outline-dark btn-mobile -lg-mr-1"
            type="button">@translate('Exchange')</a>
          <a href="@url('dashboard/topup')" class="btn btn-dark btn-mobile -lg-mr-1" type="button">@translate('Top
            up')</a>
          <a href="@url('dashboard/add')" class="btn btn-dark btn-mobile" type="button">+</a>

          <div class="-w-100 -flex -flex-beetween -mt-4 -mb-3">
            <strong class="-color-secondary">Recent transations</strong>
            <a href="@url('dashboard/transactions')">See all</a>
          </div>

          @isset($recentTransactions)
          <div class="transactions">
            @foreach ($recentTransactions as $transaction)
            @include('components.transaction', $transaction)
            @endforeach
          </div>
          @endisset

        </div>
      </div>
    </div>
  </div>
</div>

@endsection