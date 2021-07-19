@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="h-100 p-5 bg-light rounded-3">
                <h5>@translate('Admin Users')</h5>
            </div>
        </div>
        <div class="col-12">
        </div>
    </div>
</div>

@php

\App\Core\Components\Emails::sendEmailConfirmation(\App\Core\Registry::get('Account')->currentUser());

@endphp

@endsection
