
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
                'title' => 'Home Page',
                'button' => 'Register now!',
                'text' => 'Das erste Ziel besteht in der Bankenaufsicht weltweit über 25 verschiedene Messgrössen und Konzepte verwendet werden.'
            ])
        </div>
        <div class="col-12 col-lg-6">
            @include('components.banner', [
                'title' => 'Home Page',
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
            @dump(get_defined_vars())
        </div>
        @placeholder('100x100')
    </div>
</div>

@include('components.toast-container')
@include('components.footer')
