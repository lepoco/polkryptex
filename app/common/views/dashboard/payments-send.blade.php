@extends('layouts.app', [
'title' => \App\Core\Facades\Translate::string('Send money')
])
@section('content')

<div class="dashboard container -mt-5 -mb-5 -reveal">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Send money')</h4>
    </div>
    <div class="col-12">
      <form id="paymentsSend">
        <input type="hidden" name="action" value="PaymentsSend" />
        <input type="hidden" name="nonce" value="@nonce('paymentssend')" />
        <input type="hidden" name="id" value="{{ $user->getId() }}" />
        <input type="hidden" name="payee_name" value="" />

        <div class="floating-input -reveal">
          <select class="floating-input__field" placeholder="@translate('Currency')" name="wallet">
            @foreach ($user_wallets as $singleWallet)
            <option value="{{ $singleWallet->getId() }}" data-balance="{{ $singleWallet->getBalance() }}">{{
              $singleWallet->getCurrency()->getIsoCode() . ' - ' .
              \App\Core\Facades\Translate::string($singleWallet->getCurrency()->getName()) }}</option>
            @endforeach
          </select>
          <label for="wallet">@translate('Currency')</label>
        </div>

        <div class="floating-input -reveal">
          <input class="floating-input__field payee" type="text" placeholder="@translate('Payee')" name="payee"
            data-id="{{ $user->getId() }}" data-action="FindUser" data-nonce="@nonce('finduser')">
          <label for="payee">@translate('Payee')</label>
        </div>

        <div class="-flex payee-container">
        </div>

        <div class="floating-input -reveal -mt-2">
          <input class="floating-input__field" type="number" min="5" max="1000" name="amount"
            placeholder="@translate('Amount')" value="@option('amount', '')">
          <label for="amount">@translate('Amount')</label>
        </div>

        <div class="-reveal -pb-1">
          <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Send')</button>
          <a href="@url('dashboard/payments')" class="btn btn-outline-dark btn-mobile">@translate('Back to
            payments')</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection