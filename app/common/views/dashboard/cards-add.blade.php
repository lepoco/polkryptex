@extends('layouts.box', [
'title' => \App\Core\Facades\Translate::string('Add credit card'),
'background' => $base_url . 'img/pexels-photo-6347707.jpeg'
])

@section('content')
<h2 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Add credit card')</h2>
<div>
  <form id="addCard">
    <input type="hidden" name="action" value="AddCard" />
    <input type="hidden" name="nonce" value="@nonce('addcard')" />
    <input type="hidden" name="id" value="{{ $user->getId() }}" />

    @include('components.forms.input-card')

    <div class="-pb-1 -reveal">
      <button type="submit" class="btn btn-dark btn-mobile -lg-mr-1">@translate('Save card')</button>
      <a href="@url('dashboard')" class="btn btn-outline-dark btn-mobile">@translate('Back to dashboard')</a>
    </div>

  </form>
</div>
@endsection