@extends('layouts.app')
@section('content')

<div class="container py-4">
    <div class="row">
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
