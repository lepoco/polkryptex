@extends('layouts.app', [
'title' => 'Dashboard'
])
@section('content')

<div class="dashboard container pt-5 pb-5">
  <div class="row">
    <div class="col-12">
      <h3 class="-font-secondary -fw-700 -pb-3">@translate('Dashboard')</h3>
    </div>
    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>
          <h4>$3213,33</h4>
          <p>total balance</p>

          <a href="@url('dashboard/transfer')" class="btn btn-outline-dark btn-mobile -lg-mr-1"
            type="button">@translate('Make a new transfer')</a>
          <a href="@url('dashboard/topup')" class="btn btn-dark btn-mobile" type="button">@translate('Top up')</a>
        </div>
      </div>
    </div>
    <div class="col-12 -mt-5">
      Your wallets
      <hr>
      <div class="row">
        <div class="col-12 col-lg-6"></div>
      </div>
    </div>
  </div>
</div>

@endsection
