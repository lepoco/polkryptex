
@include('components.header')

<div class="box full">
    <div class="box__column">
        @yield('content')
    </div>
    <div class="box__column">
        @yield('banner')
    </div>
</div>

@include('components.footer')
