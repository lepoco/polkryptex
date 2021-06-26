<section class="hero {{ isset($dark) && true === $dark ? 'dark' : 'white'}}" @isset($background)style="background-image: url('{{ $background }}');"@endisset>
    <div class="hero__body">
        <div class="container">
            @isset($title)
                <h2>{!! str_replace('\n', '<br/>', $title) !!}</h2>
            @endisset
            @isset($text)
                <p>{!! str_replace('\n', '<br/>', $text) !!}</p>
            @endisset
        </div>
    </div>
</section>