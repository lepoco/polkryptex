@extends('layouts.panel', [
'title' => 'Admin panel'
])

@section('content')

<div class="dashboard container pt-5 pb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Panel')</h4>
    </div>
  </div>
</div>

@endsection
