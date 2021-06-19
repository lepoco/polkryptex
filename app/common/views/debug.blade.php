
@include('components.header')
@include('components.navigation')

<div class="container py-4">
    <div class="row">
        <div class="col-12 py-4">
            @include('components.banner', [
                'title' => 'DEBUG',
                'dark' => true,
                'button' => 'Go back to the home page',
                'button_link' => $baseUrl,
                'text' => 'This page is used to debug the application. It is activated by APP_DEBUG in config.php. The page should not be active in production.'
            ])
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-6">

            @component('Components::Home')

            <strong>\Polkryptex\Core\Registry::get('Session')</strong>
            @php
            dump(\Polkryptex\Core\Registry::get('Session'));
            @endphp
        </div>
        <div class="col-12 col-lg-6">
            <strong>\Polkryptex\Core\Components\Query::getUserById(1)</strong>
            @php
            $query = \Polkryptex\Core\Components\Query::getUserById(1);
            dump($query);
            @endphp
        </div>
        <div class="col-12 col-lg-6">
            <strong>Blade Debug</strong>
            @debug
        </div>
    </div>
</div>

<div class="container py-4">
    <footer class="pt-3 mt-4 text-muted border-top">
        Polkryptex © {{ date('Y') }}
    </footer>
</div>

@include('components.footer')
