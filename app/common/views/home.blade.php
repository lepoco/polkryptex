
@include('components.header')
@include('components.navigation')

<div class="container py-4">
    <div class="row">
        <div class="col-12 py-4">
            @include('components.banner', [
                'title' => 'Home Page',
                'dark' => true,
                'button' => 'Register now!',
                'text' => 'Das erste Ziel besteht in der Bankenaufsicht weltweit über 25 verschiedene Messgrössen und Konzepte verwendet werden.'
            ])
        </div>
        <div class="col-12 col-lg-6">
            @include('components.banner', [
                'title' => 'Free Account!',
                'button' => 'Register now!',
                'text' => 'Das erste Ziel besteht in der Bankenaufsicht weltweit über 25 verschiedene Messgrössen und Konzepte verwendet werden.'
            ])
        </div>
        <div class="col-12 col-lg-6">
            @include('components.banner', [
                'title' => 'Special offers!',
                'dark' => true,
                'button' => 'Register now!',
                'text' => 'Das erste Ziel besteht in der Bankenaufsicht weltweit über 25 verschiedene Messgrössen und Konzepte verwendet werden.'
            ])
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
        {{-- @php $dupa = new Symfony\Component\VarDumper\Dumper\HtmlDumper('elo'); $dupa->dump(); @endphp --}}
            @debug
        </div>
        <div class="col-12">
            @placeholder('100x100')
        </div>
    </div>
</div>

<div class="container py-4">
    <footer class="pt-3 mt-4 text-muted border-top">
        Polkryptex © {{ date('Y') }}
    </footer>
</div>

@include('components.toast-container')
@include('components.footer')
