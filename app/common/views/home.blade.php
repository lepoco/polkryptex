@extends('layouts.app')
@section('content')
<div class="container -pt-5">
    <div class="row">
        
        <div class="col-12 col-lg-6 -pb-3 -mh-70 -flex-center">
            <div>
                <h2 class="-font-secondary -fw-700">@translate('Create your cryptocurrency wallet today')</h2>
                <p>
                    @translate('Polkryptex is a simple way to buy and sell cryptocurrencies.')
                    <br>
                    <a href="@url('register')">@translate('Open your free account now')</a>
                </p>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            @include('components.phone', ['notch' => true, 'image' => $base_url . 'img/home-phone-screen.png?v=' . $version])
        </div>
        
        <div class="col-12 col-lg-6">
            @include('components.phone', ['notch' => true, 'image' => $base_url . 'img/home-phone-screen.png?v=' . $version])
        </div>
        <div class="col-12 col-lg-6 -pb-3 -mh-70 -flex-center">
            <div>
                <h3 class="-font-secondary -fw-700">@translate('All currencies\nin one place')</h3>
                <p>
                    @translate('With the help of Polkryptex you can exchange traditional currencies\nfor crypto and vice versa. It\'s fast, convenient and safe.')
                    <br>
                    <a href="@url('wallets')">@translate('Find out more about our wallets')</a>
                </p>
            </div>
        </div>

        <div class="col-12 -pt-6 -pb-3 -flex-center -flex-justify-center -text-center">
            <div>
                <h4 class="-font-secondary -fw-700">@translate('Choose a plan for yourself')</h4>
                <p>@translate('Tailored to your needs, no surprises')</p>
            </div>
        </div>
        <div class="col-12 -pb-6">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <strong>Standard</strong>
                            <p>Free</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <strong>Plus</strong>
                            <p>10$/mo</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <strong>Premium</strong>
                            <p>20$/mo</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <strong>Trader</strong>
                            <p>99$/mo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 py-4">
            @include('components.banner', [
                'title' => 'Home Page',
                'dark' => true,
                'button' => 'Register now!',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
            ])
        </div>
        <div class="col-12 col-lg-6">
            @include('components.banner', [
                'title' => 'Free Account!',
                'button' => 'Register now!',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
            ])
        </div>
        <div class="col-12 col-lg-6">
            @include('components.banner', [
                'title' => 'Special offers!',
                'dark' => true,
                'button' => 'Register now!',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
            ])
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            @placeholder('100x100')
        </div>
    </div>
</div>

@endsection
