@extends('layouts.app', [
'title' => 'Payments'
])
@section('content')

<div class="dashboard container pt-5 pb-5 -mb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Payments')</h4>
    </div>
    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>
          <h4 class="-mb-2">&commat;{{ $user->getName() ?? 'user' }}</h4>

          <a href="@url('dashboard/send')" class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('Send')
            &xrarr;</a>
          <a href="@url('dashboard/request')" class="btn btn-outline-dark btn-mobile">&xlarr;
            @translate('Request')</a>
        </div>
      </div>
    </div>
    <div class="col-12">
      @isset($payments)
        @foreach($payments as $paymentGroup)
        <div class="-w-100 -flex -flex-beetween -mt-4 -mb-3">
          <strong class="-color-secondary">{{ $paymentGroup['date'] ?? '' }}</strong>
        </div>
        <div class="transactions">
          @isset($paymentGroup['transactions'])
            <div class="transactions">
              @foreach ($paymentGroup['transactions'] as $transaction)
                @include('components.transaction', $transaction)
              @endforeach
            </div>
          @endisset
        </div>
        @endforeach
      @endisset
    </div>
  </div>
</div>

@endsection