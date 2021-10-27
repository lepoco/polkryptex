@extends('layouts.app', [
'title' => 'Contact',
])
@section('content')
<div class="container -pt-5">
  <div class="row">

    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3">@translate('Contact')</h4>
    </div>

    <div class="col-12 -mb-5">
      <div>

        <form id="contact">
          <input type="hidden" name="action" value="Contact" />
          <input type="hidden" name="nonce" value="@nonce('contact')" />
          <div class="mb-3 pr-2">
            <div class="floating-input">
              <input class="floating-input__field" type="email" name="email" placeholder="@translate('Email')">
              <label for="email">@translate('Email')</label>
            </div>
          </div>
          <div class="mb-3 pr-2">
            <div class="floating-input">
              <input class="floating-input__field" type="text" name="message" placeholder="@translate('Message')">
              <label for="message">@translate('Message')</label>
            </div>
          </div>
          <button type="submit" class="btn btn-dark btn-mobile">@translate('Send')</button>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection