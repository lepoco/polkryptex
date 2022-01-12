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

    <div class="-reveal -mb-2">
      <h4><span class="monthly-fee">$ 9,90</span></h4>
      <span>@translate('monthly fee')</span>
    </div>

    <div class="-pb-1 -reveal">
      <strong>@translate('Plan')</strong>
    </div>

    <div class="floating-radio -split">
      <label>
        <input type="radio" name="plan_tier" data-price="free" data-display="free" data-name="@translate('Standard')" value="standard" checked="checked" />
        <div class="floating-radio__label -reveal">
          <p class="-m-0 -p-0"><strong>@translate('Standard')</strong></p>
          <small>free</small>
        </div>
      </label>

      <label>
        <input type="radio" name="plan_tier" data-price="14.90" data-display="$ 14,90" data-name="@translate('Plus')" value="plus" />
        <div class="floating-radio__label -reveal">
          <p class="-m-0 -p-0"><strong>@translate('Plus')</strong></p>
          <small>$ 14,90 / month</small>
        </div>
      </label>

      <label>
        <input type="radio" name="plan_tier" data-price="29.90" data-display="$ 29,90" data-name="@translate('Premium')" value="premium" />
        <div class="floating-radio__label -reveal">
          <p class="-m-0 -p-0"><strong>@translate('Premium')</strong></p>
          <small>$ 29,90 / month</small>
        </div>
      </label>

      <label>
        <input type="radio" name="plan_tier" data-price="49.90" data-display="$ 49,90" data-name="@translate('Trader')" value="trader" />
        <div class="floating-radio__label -reveal">
          <p class="-m-0 -p-0"><strong>@translate('Trader')</strong></p>
          <small>$ 49,90 / month</small>
        </div>
      </label>
    </div>

    <div class="-reveal">
      <hr>
    </div>

    <div class="-pb-1 -reveal">
      <strong>@translate('Payment method')</strong>
    </div>

    <div class="floating-radio -split">
      @foreach ($user_cards as $user_card)
      <label>
        <input type="radio" name="card" value="{{ substr($user_card->number, -4) }}" />
        <div class="floating-radio__label -reveal">
          <div class="-flex select__card">
            <div>
              (**** <strong>{{ substr($user_card->number, -4) }}</strong>)
            </div>
            
            @media('mastercard-horizontal.svg')
          </div>
        </div>
      </label>
      @endforeach
    </div>

    <div class="form-check -reveal">
      <input type="checkbox" class="form-check-input" id="accept_currencies" name="accept_currencies" name="subscribe"
        value="accept_currencies">
      <label for="accept_currencies">@translate('I accept the terms and conditions related to subscription.')</label>
    </div>

    <div class="form-check -reveal -mb-2">
      <input type="checkbox" class="form-check-input" id="accept_auto_withdraw" name="accept_auto_withdraw" name="subscribe"
        value="accept_auto_withdraw">
      <label for="accept_auto_withdraw">@translate('I consent to the automatic withdrawal of funds from my account.')</label>
    </div>

    <div class="-pb-1 -reveal">
      <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Activate')</button>
      <a href="@url('dashboard/cards/add')" class="btn btn-outline-dark btn-mobile -lg-mr-1">@translate('Add new card')</a>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>

  </form>
</div>
@endsection