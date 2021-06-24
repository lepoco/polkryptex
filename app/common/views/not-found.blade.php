@extends('layouts.box')

@section('content')
    <h1 class="accent">@translate('Ups!')</h1>
    <p>@translate('The page you are looking for has not been found.')</p>
    <a href="@url" class="btn btn-dark">@translate('Back to the home page')</a>
@endsection

@section('banner')
😅
@endsection
