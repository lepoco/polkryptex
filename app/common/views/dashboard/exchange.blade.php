@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Exchange'),
'background' => $base_url . 'img/pexels-person-holding-bitcoin.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Exchange')</h2>
<div class="-reveal">
  <form id="exchange">
    <input type="hidden" name="action" value="Exchange" />
    <input type="hidden" name="nonce" value="@nonce('exchange')" />

    <div class="floating-input">
      <input class="floating-input__field" type="number" placeholder="@translate('Amount')" name="amount">
      <label for="new_password">@translate('Amount')</label>
    </div>

    <p>from</p>
    <p>to</p>
    <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Exchange currencies')</button>
    <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
  </form>
</div>
@endsection