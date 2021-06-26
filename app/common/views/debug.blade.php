@extends('layouts.app')
@section('content')

<div class="container py-4">
    <div class="row">
        <div class="col-12 py-4">
            @include('components.banner', [
                'title' => 'DEBUG',
                'dark' => true,
                'button' => 'Go back to the home page',
                'button_link' => $baseUrl,
                'text' => 'This page is used to debug the application. It is activated by APP_DEBUG in config.php. Turn off this variable in production.'
            ])
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-6">
            <strong>\App\Core\Registry::get('Session')</strong>
            @php
            dump(\App\Core\Registry::get('Session'));
            @endphp

            <strong>$_SESSION</strong>
            @php
            dump($_SESSION);
            @endphp
        </div>
        <div class="col-12 col-lg-6">
            <strong>\App\Core\Components\Query::getUserById(1)</strong>
            @php
            $query = \App\Core\Components\Query::getUserById(1);
            dump($query);
            @endphp
        </div>
        <div class="col-12 col-lg-6">
            <strong>Blade Debug</strong>
            @debug
        </div>
        <div class="col-12 col-lg-6">
            <strong>\App\Core\Registry::get('Account')->currentUser()</strong>
            @php
            dump(\App\Core\Registry::get('Account')->currentUser());
            @endphp

            <strong>\App\Core\Registry::get('Account')->isLoggedIn()</strong>
            @php
            dump(\App\Core\Registry::get('Account')->isLoggedIn());
            @endphp

            <strong>\App\Core\Registry::get('Response')</strong>
            @php
            dump(\App\Core\Registry::get('Response'));
            @endphp
        </div>
        <div class="col-12 col-lg-6">
            <strong>\App\Core\Registry::get('Request')</strong>
            @php
            dump(\App\Core\Registry::get('Request'));
            @endphp
        </div>
    </div>
</div>

@endsection
