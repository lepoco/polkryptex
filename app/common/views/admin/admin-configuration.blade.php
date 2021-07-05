@extends('layouts.admin')
@section('content')

<form>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 -pl-1 -pb-2">
                <strong>@translate('Global settings')</strong>
            </div>
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="option_host" placeholder="@translate('Host')" value="@option('host')">
                    <label for="option_host">@translate('Host')</label>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="option_baseurl" placeholder="@translate('Base URL')" value="@option('baseurl')">
                    <label for="option_baseurl">@translate('Base URL')</label>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="option_site_name" placeholder="@translate('Site name')" value="@option('site_name')">
                    <label for="option_site_name">@translate('Site name')</label>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="option_site_description" placeholder="@translate('Site description')" value="@option('site_description')">
                    <label for="option_site_description">@translate('Site description')</label>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="option_dashboard" placeholder="@translate('Dashboard URL')" value="@option('dashboard')">
                    <label for="option_dashboard">@translate('Dashboard URL')</label>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="floating-input">
                    <input class="floating-input__field" type="text" name="option_admin" placeholder="@translate('Site description')" value="@option('admin')">
                    <label for="option_admin">@translate('Admin URL')</label>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
