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
                    <h5>1000` EUR</h5>
                    <div class="-flex">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Polish Zloty</option>
                            <option value="1">Euro</option>
                            <option value="2">US Dollar</option>
                            <option value="3">Three</option>
                        </select>
                        <a href="@dashurl('wallet/topup')" class="btn btn-dark" type="button">@translate('Transfer')</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
        </div>
    </div>
</div>

@endsection
