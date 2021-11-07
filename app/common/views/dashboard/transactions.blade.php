@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Transactions')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5 -reveal">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Transactions')</h4>
    </div>
    <div class="col-12 dashboard__section">

      @isset($transactions)
      <div class="transactions">
        @foreach ($transactions as $transaction)
        @include('components.transaction', ['transaction' => $transaction])
        @endforeach
      </div>
      @endisset

    </div>
  </div>
</div>

@endsection