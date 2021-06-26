
<!doctype html>
<html lang="@option('language', 'en')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-control" content="private">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=0">
    <meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
@if($noTranslate)
    <meta name="google" value="notranslate" />
@endif
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <title>Polkryptex - {{ $title }}</title>
    <link rel="icon" href="@media('icons/favicon.ico')"/>
    <link rel="manifest" href="@media('m.webmanifest')">
    <script type="importmap">@json( $importmap )</script>

@foreach($styles as $style)
    <link type="text/css" rel="stylesheet" href="{{ $style['src'] }}" integrity="{{ $style['sri'] }}" crossorigin="anonymous" />
@endforeach 

    <script>const app = {title: '{{ $title }}', props: @json( $props ), csrf: '{{ $csrfToken }}', auth: @json( $auth, JSON_PRETTY_PRINT )}</script>
@foreach($scripts as $script)
    <script type="{{ $script['type'] }}" src="{{ $script['src'] }}" integrity="{{ $script['sri'] }}" crossorigin="anonymous" defer></script>
@endforeach

</head>
<body class="{{ implode(' ', $bodyClasses) }}">

@include('components.cookie')

<div id="app">