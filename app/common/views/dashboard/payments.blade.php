@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Payments')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5 -reveal">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Payments')</h4>
    </div>
    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>
          <h4 class="-mb-2">&commat;{{ $user->getName() ?? 'user' }}</h4>

          <a href="@url('dashboard/payments/send')" class="btn btn-outline-dark btn-mobile -lg-mr-1">
            @translate('Send')
            <i class="icon-ic_fluent_chevron_double_right_20 -s-16 -ml-1"></i>
          </a>
          <a href="@url('dashboard/payments/request')" class="btn btn-outline-dark btn-mobile">
            <i class="icon-ic_fluent_chevron_double_left_20 -s-16 -mr-1"></i>
            @translate('Request')
          </a>
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