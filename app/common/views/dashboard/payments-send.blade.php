@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Send money')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5 -reveal">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Send money')</h4>
    </div>
    <div class="col-12 dashboard__section">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection