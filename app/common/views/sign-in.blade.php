@extends('layouts.box', ['background' => $baseUrl . 'media/images/pexels-person-holding-bitcoin.jpeg'])

@section('content')
    <h4 class="-font-secondary -fw-700 -pb-3">@translate('Sign In')</h4>
    <form id="signin">
        <input type="hidden" name="action" value="SignIn"/>
        <input type="hidden" name="nonce" value="@nonce('signin')"/>
        <div class="mb-3 pr-2">
            <div class="floating-input">
                <input class="floating-input__field" type="email" name="email" placeholder="@translate('Email')">
                <label for="email">@translate('Email')</label>
            </div>
        </div>
        <div class="mb-3 pr-2">
            <div class="floating-input">
                <input class="floating-input__field" type="password" name="password" placeholder="@translate('Password')">
                <label for="password">@translate('Password')</label>
            </div>
        </div>
        <button type="submit" class="btn btn-dark -mb-1">@translate('Sign in')</button> <a href="@url" class="btn btn-secondary -mb-1">@translate('Back to home')</a>
    </form>
@endsection

@section('banner')
@endsection
