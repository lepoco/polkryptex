@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Successfully registered'),
'background' => $base_url . 'img/pexels-person-holding-bitcoin.jpeg'
])

@section('content')
@if($isResend ?? false)
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Link sent')</h2>
@else
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Successfully registered')</h2>
@endif
<p class="-pb-2 -reveal">@translate('Thank you for your registration. A message with a confirmation link should be sent to your inbox.')</p>
<div class="-reveal -pb-1">
  <a href="@url('signin')" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Sign in')</a>
  <a href="{{ $resendLink ?? '#' }}" class="btn btn-secondary btn-mobile">@translate('Resend confirmation link')</a>
</div>
@endsection