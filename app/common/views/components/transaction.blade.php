@php
  $methodName = $transaction->getMethodName();
  $typeName = $transaction->getTypeName();

  $methodDisplayName = 'app';

  switch ($methodName) {
    case 'apple_pay':
      $methodDisplayName = 'Apple Pay';
      break;

    case 'google_pay':
      $methodDisplayName = 'Google Pay';
      break;

    case 'paypal':
      $methodDisplayName = 'PayPal';
      break;

    case 'card':
      $methodDisplayName = \App\Core\Facades\Translate::string('Credit Card');
      break;
  }

  $header = '';

  switch ($typeName) {
    case 'topup':
      $currency = $transaction->getWalletTo()->getCurrency();
      $header = \App\Core\Facades\Translate::string('Top-up via') . ' ' . $methodDisplayName;
      break;

    case 'transfer':
      $currency = $transaction->getWalletFrom()->getCurrency();
      $header = \App\Core\Facades\Translate::string('Transfer');
      break;
    
    default:
      $currency = $transaction->getWalletTo()->getCurrency();
      $header = \App\Core\Facades\Translate::string('Transaction');
      break;
  }
@endphp

<div class="-w-100 -reveal">
  <a href="{{ $transaction->getUrl() ?? '#' }}">
    <div class="transactions__single">
      <div>
        <img src="@asset('img/pexels-watch-pay.jpeg')" alt="image">
      </div>

      <span>
        <p><strong>{{ $header ?? '' }}</strong></p>
        @if('topup' === $typeName)
        <span>{{ $transaction->getCreatedAt() ?? '' }}</span>
        @elseif('transfer' === $typeName)
        <span>
          @translate('From') <strong>{{ $transaction->getWalletFrom()->getCurrency()->getIsoCode() }}&#64;{{ strtoupper($transaction->getUserFromName()) }}</strong> @translate('To') <strong>{{ $transaction->getWalletTo()->getCurrency()->getIsoCode() }}&#64;{{ strtoupper($transaction->getUserToName()) }}</strong> - {{ $transaction->getCreatedAt() ?? '' }}
        </span>
        @endif
      </span>

      <strong>
        {{ $currency->isSignLeft() ? $currency->getSign() : '' }} {{ number_format((float) ($transaction->getAmount() * $transaction->getRate()) ?? 0, 2, '.', '') }}
        {{ !$currency->isSignLeft() ? $currency->getSign() : '' }}
      </strong>
    </div>
  </a>
</div>