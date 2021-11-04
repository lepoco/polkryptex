@extends('layouts.panel', [
'title' => \App\Core\Facades\Translate::string('Tools')
])

@section('content')

<div class="dashboard container pt-5 pb-5">
  <div class="row">
    <div class="col-12">
      <h4 class="-font-secondary -fw-700 -pb-3 -reveal">@translate('Tools')</h4>
    </div>

    <div class="col-12 col-lg-4 -pb-3 -reveal">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>
          <h3 class="-flex"> <i class="icon-ic_fluent_people_20 -s-24 -mr-1"></i> {{ $cached_blade ?? 0 }}</h3>
          <p>@translate('Cached views')</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4 -pb-3 -reveal">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>
          <h3 class="-flex"> <i class="icon-ic_fluent_payment_24 -s-24 -mr-1"></i> {{ $cached_records ?? 0 }}</h3>
          <p>@translate('Cache records')</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4 -pb-3 -reveal">
      <div class="dashboard__banner h-100 p-5 bg-light -rounded-2">
        <div>
          <h3 class="-flex"> <i class="icon-ic_fluent_fingerprint_24 -s-24 -mr-1"></i> {{ $logs_count ?? 0 }}</h3>
          <p>@translate('Log files')</p>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <form id="panelFlushBlade" method="POST">
        <input type="hidden" name="action" value="PanelFlushBlade" />
        <input type="hidden" name="nonce" value="@nonce('panelflushblade')" />
        <button type="submit" class="btn btn-dark btn-mobile -w-100">@translate('Flush blade views')</button>
      </form>
    </div>

    <div class="col-12 col-lg-4">
      <form id="panelFlushCache" method="POST">
        <input type="hidden" name="action" value="PanelFlushCache" />
        <input type="hidden" name="nonce" value="@nonce('panelflushcache')" />
        <button type="submit" class="btn btn-dark btn-mobile -w-100">@translate('Flush cache')</button>
      </form>
    </div>

    <div class="col-12 col-lg-4">
      <form id="panelFlushLogs" method="POST">
        <input type="hidden" name="action" value="PanelFlushLogs" />
        <input type="hidden" name="nonce" value="@nonce('panelflushlogs')" />
        <button type="submit" class="btn btn-dark btn-mobile -w-100">@translate('Flush logs')</button>
      </form>
    </div>

    <div class="col-12 -mt-2 -mb-2">
      <hr>
    </div>
  </div>
</div>

@endsection
