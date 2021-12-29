@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Account not active'),
'background' => $base_url . 'img/pexels-photo-6347707.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Unconfirmed')</h2>
<div class="-reveal">
  <p>@translate('Your account has not been activated yet. Click on the link you received in the email.')</p>
</div>
<div>
  <form id="unconfirmed">
    <input type="hidden" name="action" value="Unconfirmed" />
    <input type="hidden" name="nonce" value="@nonce('unconfirmed')" />
    <input type="hidden" name="id" value="{{ $user->getId() }}" />
    <div class="-reveal -pb-1">
      <a href="{{ $resendLink ?? '#' }}" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Resend link')</a>
      <a href="@url('signout')" class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('Sign out')</a>
    </div>
  </form>
</div>
@endsection