<div class="-w-100">
  <a href="{{ $url ?? '#' }}">
    <div class="transactions__single">
      <div>
        <img src="@asset('img/pexels-watch-pay.jpeg')" alt="image">
      </div>

      <span>
        <p><strong>{{ $description ?? '' }}</strong></p>
        <span>@translate('From') <strong>US@you</strong> @translate('to') <strong>EUR@you</strong> - {{ $date ?? '' }}</span>
      </span>

      <strong>
        {{ $amount ?? 0 }} {{ $currency ?? 'USD' }}
      </strong>
    </div>
  </a>
</div>