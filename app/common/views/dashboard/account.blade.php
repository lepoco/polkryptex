
@include('components.header')
@include('components.navigation')

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>@translate('My Account')</h2>
            @dump($user)
        </div>
    </div>
</div>

@include('components.footer')
