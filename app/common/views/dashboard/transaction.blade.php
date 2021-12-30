@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Transaction')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3 -reveal">{{ $header ?? 'Transaction'}}</h4>
    </div>
    <div class="col-12 dashboard__section -reveal">

      @if($isValid ?? false)
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div class="-w-100">
          <h4>
            {{ $currency->isSignLeft() ? $currency->getSign() : '' }} {{ number_format((float) $transaction->getAmount()
            ?? 0, 2, '.', '') }}
            {{ !$currency->isSignLeft() ? $currency->getSign() : '' }}
          </h4>
          <span><i>{{ $transaction->getUUID() ?? ''}}</i></span>
          <p>@translate($currency->getName())</p>

        </div>

        @if($isTopup)
        <div class="transaction_image">

          @switch($methodName)
              @case('paypal')
                  @media('paypal.svg')
                  @break
              @case('google_pay')
                  @media('google-pay.svg')
                  @break
              @case('card')
                  @media('mastercard-horizontal.svg')
                  @break
              @case('apple_pay')
                  @media('apple-pay.svg')
                  @break
              @default
                  
          @endswitch
        </div>
        @endif
      </div>
      @else
      <p>@translate('Specified transaction could not be found.')</p>
      @endif
    </div>

    <div class="col-12 -mt-3 -pb-2 -reveal">
      <a href="@url('dashboard/transactions')" class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('See all')</a>
      <a href="@url('dashboard')" class="btn btn-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>
  </div>
</div>

@endsection