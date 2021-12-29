@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Registeration confirmation'),
'background' => $base_url . 'img/pexels-person-holding-bitcoin.jpeg'
])

@section('content')

@if($isValid)


<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Account confirmed')</h2>
<p class="-pb-2 -reveal">@translate('Thank you for confirming your account, you can log in now.')</p>
<div class="-reveal -pb-1">
  @if($isLoggedIn)
  <a href="@url('dashboard')" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Go to dashboard')</a>
  @else
  <a href="@url('signin')" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Sign in')</a>
  @endif
</div>

@else

<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('The link is expired or invalid')</h2>
<p class="-pb-2 -reveal">@translate('This account has already been confirmed, or something has gone wrong. If you need
  help, please contact customer service.')</p>
<div class="-reveal -pb-1">
  <a href="@url('signin')" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Sign in')</a>
</div>

@endif
@endsection