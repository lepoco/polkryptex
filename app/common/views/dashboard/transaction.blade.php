@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Transaction')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5 -reveal">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Transaction')</h4>
    </div>
    <div class="col-12 dashboard__section">

      @if($is_valid ?? false)
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div class="-w-100">
          <h4>
            {{ $currency->isSignLeft() ? $currency->getSign() : '' }} {{ number_format((float) $transaction->getAmount()
            ?? 0, 2, '.', '') }}
            {{ !$currency->isSignLeft() ? $currency->getSign() : '' }}
          </h4>
          <span><i>{{ $transaction->getUUID() ?? ''}}</i></span>
          <p>{{ $currency->getName() ?? ''}}</p>

        </div>
      </div>
      @else
      <p>@translate('Specified transaction could not be found.')</p>
      @endif
    </div>
  </div>
</div>

@endsection