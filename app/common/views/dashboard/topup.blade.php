@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Top up'),
'background' => $base_url . 'img/pexels-person-holding-bitcoin.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Top up')</h2>
<div class="-reveal">
  <form id="topup">
    <input type="hidden" name="action" value="Topup" />
    <input type="hidden" name="nonce" value="@nonce('topup')" />
    <p>paypal</p>
    <p>apple pay</p>
    <p>google pay</p>
    <p>card</p>
    <p>przelewy</p>
    <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Top up')</button>
    <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
  </form>
</div>
@endsection