@extends('layouts.box', ['background' => $baseUrl . 'media/images/pexels-person-holding-bitcoin.jpeg'])

@section('content')
    <h4 class="-font-secondary -fw-700 -pb-3">@translate('Register')</h4>
    <form id="register">
        <input type="hidden" name="action" value="Register"/>
        <input type="hidden" name="nonce" value="@nonce('register')"/>
        <div class="mb-3 pr-2">
            <div class="floating-input">
                <input class="floating-input__field" type="text" name="username" placeholder="@translate('Username')">
                <label for="username">@translate('Username')</label>
            </div>
        </div>
        <div class="mb-3 pr-2">
            <div class="floating-input">
                <input class="floating-input__field" type="email" name="email" placeholder="@translate('Email address')">
                <label for="email">@translate('Email address')</label>
            </div>
        </div>
        <div class="mb-3 pr-2">
            <div class="floating-input">
                <input class="floating-input__field" type="password" name="password" placeholder="@translate('Password')">
                <label for="password">@translate('Password')</label>
            </div>
        </div>
        <div class="mb-3 pr-2">
            <div class="floating-input">
                <input class="floating-input__field" type="password" name="password_confirm" placeholder="@translate('Confirm Password')">
                <label for="password_confirm">@translate('Confirm Password')</label>
            </div>
        </div>
        <button type="submit" class="btn btn-dark">@translate('Register')</button> <a href="@url" class="btn btn-secondary">@translate('Back to home')</a>
    </form>
@endsection

@section('banner')
@endsection
