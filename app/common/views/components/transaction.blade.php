@php

  $methodName = '';
  
  if(!isset($method)) {
    $method = 'internal';
  }

  if(!isset($type)) {
    $type = 'transfer';
  }

  if(!isset($currency)) {
    $currency = new \App\Common\Money\Currency(0);
  }

  switch ($method) {
    case 'apple_pay':
      $methodName = 'Apple Pay';
      break;

      case 'google_pay':
      $methodName = 'Google Pay';
      break;

    case 'paypal':
      $methodName = 'Paypal';
      break;

    case 'card':
      $methodName = 'Card';
      break;
    
    default:
      $methodName = $method;
      break;
  }

  if('topup' === $type) {
    $header = 'Top-up via ' . $methodName;
  }

@endphp
<div class="-w-100 -reveal">
  <a href="{{ $url ?? '#' }}">
    <div class="transactions__single">
      <div>
        <img src="@asset('img/pexels-watch-pay.jpeg')" alt="image">
      </div>

      <span>
        <p><strong>{{ $header ?? '' }}</strong></p>
        @if('topup' === $type)
        <span>{{ $date ?? '' }}</span>
        @else
        <span>
          @translate('From') <strong>US@you</strong> @translate('to') <strong>EUR@you</strong> - {{ $date ?? '' }}
        </span>
        @endif
      </span>

      <strong>
        {{ $currency->isSignLeft() ? $currency->getSign() : '' }} {{ number_format((float) $amount ?? 0, 2, '.', '') }}
        {{ !$currency->isSignLeft() ? $currency->getSign() : '' }}
      </strong>
    </div>
  </a>
</div>