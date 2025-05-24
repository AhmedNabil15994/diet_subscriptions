@extends('apps::frontend.layouts.app')
@section( 'title',__('home'))
@push('css')
  <style>
    .fa-sign-out-alt{
      font-size: 22px;
      margin-right: 12px;
      margin-left: 0;
    }
    html[lang="ar"] .fa-sign-out-alt{
      margin-left: 12px;
      margin-right: 0;
    }
  </style>
@endpush
@section( 'content')

<div class="inner-page">
  <div class="container">
    <div class='row'>
      <div class="col-md-3">
        <div class='user-menu'>
          <a class="{{ active_profile('frontend.profile.index') }}" href="{{ route('frontend.profile.index') }}">
            <img class="img-fluid icon-img" src="{{asset('frontend')}}/images/icons/user.svg" alt="" />
            <span>{{ __('Account Details') }}</span>
          </a>
          <a class="{{ active_profile('frontend.subscriptions.index') }}" href="{{route('frontend.subscriptions.index') }}">
            <img class="img-fluid icon-img" src="{{asset('frontend')}}/images/icons/bag-2.svg" alt="" />
            <span>{{ __('My Subscriptions') }}</span>
          </a>
          <a  href="{{ route('frontend.auth.logout') }}">
            <i class="fas fa-sign-out-alt fa-sharp fa-solid"></i>
            <span class="btn-text"> {{ __('logout') }}</span>
          </a>
        </div>
      </div>
      <div class="col-md-9">
        <div class="cart-list orders-list">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="default-sub-tab" data-bs-toggle="pill" data-bs-target="#default-sub" type="button" role="tab"
                aria-controls="default-sub" aria-selected="true">{{ __('default subscription') }}</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                aria-controls="pills-profile" aria-selected="false">{{ __('History') }}</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="default-sub" role="tabpanel" aria-labelledby="default-sub-tab">
              @if($currentSubscription)
              <div class="order-item">
                <div class="d-flex align-items-center justify-content-between">
                    @if($currentSubscription?->is_default)
                    <div class="order-number">
                      <span class="order-status delivered">
                        {{ __('active') }}
                      </span>
                    </div>
                    @if($currentSubscription->end_at < now())
                      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        {{ __('renew package') }}
                      </button>
                    @else
                      <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#pauseSubscriptionModel">
                        {{__('Pause your subscription')}}
                      </button>
                    @endif
                  @endif
                </div>
                <div class="d-flex align-items-end justify-content-between">
                  <ul class="options">
                    <li>
                      <i class="ti-star"></i>
                      {{ __('package') }}
                      {{ $currentSubscription->package?->title }}
                    </li>
                    <li>
                      <i class="ti-star"></i>
                      {{ __('price') }}
                      {{ $currentSubscription->price - (isset($currentSubscription->coupon) && isset($currentSubscription->coupon->discount_value) ? $currentSubscription->coupon->discount_value : 0) }}
                    </li>
                    <li>
                      <i class="ti-time"></i>
                      {{ __('start') }}
                      {{ $currentSubscription->start_at }}
                    </li>
                    @if($currentSubscription->pause_end_at && $currentSubscription->pause_end_at > now())
                      @if($currentSubscription->pause_start_at)
                        <li>
                          <i class="ti-time"></i>
                          {{ __('Pause start') }}
                          {{ $currentSubscription->pause_start_at }}
                        </li>
                      @endif
                      @if($currentSubscription->pause_end_at)
                        <li>
                          <i class="ti-time"></i>
                          {{ __('Pause end') }}
                          {{ $currentSubscription->pause_end_at }}
                        </li>
                      @endif
                    @endif
                    <li>
                      <i class="ti-time"></i>
                      {{ __('end at') }}
                      {{ $currentSubscription->end_at }}
                    </li>
                  </ul>
                </div>
              </div>
              @endif
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              @if(count($subscriptions))
                @foreach ($subscriptions as $subscription)
                <div class="order-item">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="order-number"></div>
                      @if($subscription->paid == 'paid')
                        <span class="order-status delivered">
                          {{ $subscription->end_at > now() ? __('active') : __('ended') }}
                        </span>
                      @else
                        <span class="order-status {{ $subscription->paid == 'pending' ?  'under-processing' : 'canceled'}}">
                          {{ __($subscription->paid) }} {{ __('payment') }}
                        </span>
                      @endif
                  </div>
                  <div class="d-flex align-items-end justify-content-between">
                    <ul class="options">
                      <li>
                        <i class="ti-star"></i>
                        {{ __('package') }}
                        {{ $subscription->package?->title }}
                      </li>
                      <li><i class="ti-time"></i>{{ __('start') }}
                        {{$subscription->start_at }}</li>
                      <li><i class="ti-time"></i>{{ __('end at') }}
                        {{ $subscription->end_at }}</li>
                    </ul>
                  </div>
                </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('frontend.packages.renew') }}" method="post" id="renew-form">
          @csrf
          <h5 class="address-name">{{ __('Choose Date') }}</h5>
          <div id="datepicker"></div>
          <input type="hidden" name="start_date" value="{{ date('Y-m-d') }}">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" form="renew-form" class="btn btn-primary" onclick="submitForm(this)">
          <span class="title">{{ __('renew') }}</span>
          <span class="loader" style="display: none"><x-front-btn-loader/></span>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="pauseSubscriptionModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('frontend.packages.pause.subscription') }}" method="post" id="pause-subscription">
          @csrf
          <div class="row">
            {!! field('front')->date('pause_start_at' , __('Pause start at'),null,[
              'min' => Carbon\Carbon::now()->addDay()->toDateString(),
              'max' => Carbon\Carbon::parse($currentSubscription?->end_at)->toDateString(),
              ]) !!}
            {!! field('front')->date('pause_end_at' , __('Pause end at'),null,[
              'min' => Carbon\Carbon::now()->addDay()->toDateString(),
              'max' => Carbon\Carbon::parse($currentSubscription?->end_at)->toDateString(),
              ]) !!}
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" form="pause-subscription" class="btn btn-primary">{{ __('save') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection

<!-- Modal -->
@push('js')
<script>
  $("#datepicker").change(function () {
    $('[name="start_date"]').val($(this).val())
  })
  function submitForm(btn) {
    btn = $(btn);
    btn.prop('disabled', true);
    btn.find('.title').hide();
    btn.find('.loader').show();
    $("#renew-form").submit();
  }
</script>
@endpush
