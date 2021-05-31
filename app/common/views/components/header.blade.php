
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=5, viewport-fit=cover, user-scalable=0">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="google" value="notranslate" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <title>Polkryptex - {{ $title }}</title>
    <script type="importmap">@json( $importmap )</script>
@foreach($styles as $style)
    <link type="text/css" rel="stylesheet" href="{{ $style['src'] }}" integrity="{{ $style['sri'] }}" crossorigin="anonymous" />
@endforeach

@foreach($scripts as $script)
    <script type="{{ $script['type'] }}" src="{{ $script['src'] }}" integrity="{{ $script['sri'] }}" crossorigin="anonymous" defer></script>
@endforeach

</head>

<body class="{{ $body_classes }}">

@if($installed)
    @include('components.cookie')
@endif

<section id="app" data-vue-component="{{ $title }}" data-vue-props="@json( $props )" data-csrf-token="{{ $csrf_token }}" data-auth="@json( $auth )">