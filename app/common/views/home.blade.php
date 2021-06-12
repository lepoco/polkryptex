
@include('components.header')
@include('components.navigation')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>@translate('Home page')</h2>
        </div>
        <div class="col-12">
            @dump(get_defined_vars())
        </div>
        @placeholder('100x100')
    </div>
</div>

@include('components.toast-container')
@include('components.footer')
