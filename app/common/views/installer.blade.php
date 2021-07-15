@extends('layouts.box', ['background' => $baseUrl . 'media/images/pexels-person-holding-bitcoin.jpeg'])

@section('content')
    <h2 class="-font-secondary -fw-700 -pb-3">@translate('Installer')</h2>
    <form id="install" class="-pr-2">
        <input type="hidden" name="action" value="Install"/>
        <div class="row">
            <div class="col-12 mb-3">
                <strong>@translate('Database')</strong>
            </div>

            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="user" placeholder="@translate('User')">
                    <label for="user">@translate('User')</label>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="password" placeholder="@translate('Password')">
                    <label for="password">@translate('Password')</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="host" placeholder="@translate('Host')" value="127.0.0.1">
                    <label for="host">@translate('Host')</label>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="table" placeholder="@translate('Table')" value="polkryptex">
                    <label for="table">@translate('Table')</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3 mt-3">
                <strong>@translate('User')</strong>
            </div>

            <div class="col-12">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="admin_username" placeholder="@translate('Username')">
                    <label for="admin_username">@translate('Username')</label>
                </div>
                <div class="floating-input">
                    <input class="floating-input__field" type="email" name="admin_email" placeholder="@translate('Email')">
                    <label for="admin_email">@translate('Email')</label>
                </div>
                <div class="floating-input">
                    <input class="floating-input__field" type="password" name="admin_password" placeholder="@translate('Password')">
                    <label for="admin_password">@translate('Password')</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-dark mt-3">@translate('Begin installation')</button>
    </form>
@endsection

@section('banner')
@endsection
