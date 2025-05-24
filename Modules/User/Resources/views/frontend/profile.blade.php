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
        <form action="{{route('frontend.profile.update') }}" class="contact-form" method="post">
          @csrf
          <h3 class="inner-title">{{ __('Account Details') }}</h3>
          <div class="row">
            <div class="col-md-6 form-group">
              <label class='form-label'>{{ __('Name') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="name" value="{{ auth()->user()->name }}" placeholder="">
            </div>
            <div class="col-md-6 form-group">
              <label class='form-label'>{{ __('Email') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="email" name="email" value="{{ auth()->user()->email }}" placeholder="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group" dir="ltr">
              <label class='form-label'>{{ __('mobile') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="text" id="mobile" value="{{ auth()->user()->mobile }}">
              <input type="hidden" name="mobile_country" id="mobile_country" value="{{ auth()->user()->mobile_country }}">
            </div>
            <div class="col-md-6 form-group">
              <label class='form-label'>{{ __('New Password') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="">
            </div>
            <div class="col-md-6 form-group">
              <label class='form-label'>{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="password" name="password_confirmation" placeholder="">
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button class="btn theme-btn" type="submit">{{ __('Save Changes') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
