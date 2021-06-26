
@include('components.header')

<div class="box full">
    <div class="box__column">
        @yield('content')
    </div>
    <div class="box__column"@isset($background) style="background-image: url('{{ $background }}')"@endisset>
        @yield('banner')
    </div>
</div>

@include('components.footer')
