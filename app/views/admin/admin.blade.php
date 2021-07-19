@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="h-100 p-5 bg-light rounded-3">
                <h5>@translate('Admin Dashboard')</h5>
            </div>
        </div>
        <div class="col-12">
        </div>
    </div>
</div>

@php

//$mail = new \App\Core\Components\Mailer();
//$mail->send('office@rdev.cc', 'Hello in Polkryptex', 'This is a wellcome message');

@endphp

@endsection
