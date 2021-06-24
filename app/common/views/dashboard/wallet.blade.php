@extends('layouts.app')
@section('content')

<div class="wallet container pt-5 pb-5">
    <div class="row">
        <div class="col-12">
            <div class="wallet__banner h-100 p-5 bg-light rounded-3">
                <div>
                    @placeholder('100x100')
                </div>
                <div>
                    <h2>1000` EUR</h2>
                    <p>currency</p>
                    <a href="@dashurl('wallet/transfer')" class="btn btn-outline-dark" type="button">@translate('Select currency')</a> <a href="@dashurl('wallet/topup')" class="btn btn-dark" type="button">@translate('Transfer')</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
