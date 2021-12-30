@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Subscription plan'),
'background' => $base_url . 'img/pexels-photo-6347707.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Subscription plan')</h2>
<div>
  <form id="selectPlan">
    <input type="hidden" name="action" value="SelectPlan" />
    <input type="hidden" name="nonce" value="@nonce('selectplan')" />
    <input type="hidden" name="id" value="{{ $user->getId() }}" />


    <section id="plan-select">


      <div class="-reveal -mb-2">
        <h4><span class="monthly-fee">USD 123,00</span></h4>
        <span>@translate('monthly fee')</span>
      </div>

      <div class="floating-radio -split">
        <label>
          <input type="radio" name="payment_method" value="apple_pay" checked="checked" />
          <div class="floating-radio__label -reveal">
            Standard
          </div>
        </label>

        <label>
          <input type="radio" name="payment_method" value="google_pay" />
          <div class="floating-radio__label -reveal">
            Plus
          </div>
        </label>

        <label>
          <input type="radio" name="payment_method" value="paypal" />
          <div class="floating-radio__label -reveal">
            Premium
          </div>
        </label>

        <label>
          <input type="radio" name="payment_method" value="card" />
          <div class="floating-radio__label -reveal">
            Trader
          </div>
        </label>
      </div>

      <div class="-pb-1 -reveal">
        <button type="button" class="btn btn-dark btn-mobile btn-plan-next-card">@translate('Next')</button>
      </div>

    </section>

    <section id="plan-card" class="-hidden">

      <div>
        @include('components.forms.input-card')
      </div>

      <div class="-pb-1">
        <button type="button" class="btn btn-dark btn-mobile btn-plan-next-finish">@translate('Next')</button>
      </div>

    </section>

    <section id="plan-finish" class="-hidden">
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="accept_currencies" name="accept_currencies" name="subscribe"
          value="accept_currencies">
        <label for="accept_currencies">@translate('I accept the terms and conditions related to subscription.')</label>
      </div>

      <div class="form-check -mb-2">
        <input type="checkbox" class="form-check-input" id="accept_currencies" name="accept_currencies" name="subscribe"
          value="accept_currencies">
        <label for="accept_currencies">@translate('I consent to the automatic withdrawal of funds from my
          account.')</label>
      </div>

      <div class="-pb-1">
        <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Activate')</button>
        <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
      </div>
    </section>

  </form>
</div>
@endsection