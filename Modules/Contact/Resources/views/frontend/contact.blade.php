@extends('apps::frontend.layouts.app')
@section('title', __('Contact Us'))
@section('content')
<div class="inner-page">
  <div class="container">
    <div class="contact-page">
      <div class="section-block">
        <div class="section-title text-center">
          <h2><span>{{ __('Keep in touch with us') }}</span></h2>
          <p class="sub-title-p">
            {{
            __('We’re talking about clean beauty gift sets, of course – and we’ve got a bouquet of beauties for yourself or someone you love') }}
          </p>
        </div>
        <div class="row">
          <div class="col-md-4">
            <a class="contact-block text-center d-block" href="mailto:{{ setting('contact_us', 'email') }}">
              <img class="img-fluid" src="{{asset('frontend')}}/images/icons/email-2.svg" alt='' />
              <h3>{{ __('email') }}</h3>
            </a>
          </div>
          <div class="col-md-4">
            <a class="contact-block text-center d-block" href="tel:{{ setting('contact_us', 'call_number') }}">
              <img class="img-fluid" src="{{asset('frontend')}}/images/icons/phone.svg" alt='' />
              <h3>{{ __('phone') }}</h3>
            </a>
          </div>
          <div class="col-md-4">
            <a class="contact-block text-center d-block" href="https://wa.me/{{ setting('contact_us', 'whatsapp') }}?text=How can we help?">
              <img class="img-fluid" src="{{asset('frontend')}}/images/icons/whatsapp.svg" alt='' />
              <h3>{{ __('Whatsapp') }}</h3>
            </a>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-9 col-12 contact-form">
          <div class="section-title text-center">
            <h2><span>{{ __('Send Message') }}</span></h2>
          </div>
          {!! Form::open(['url' => route('frontend.contacts.post'), 'method' => 'POST', 'id' => 'updateForm', 'role' => 'form',
          'files' => true]) !!}
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="form-label">{{ __('name') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="name" data-name="name" placeholder="{{ __('name') }}">
              <span class="help-block" style="">

              </span>
            </div>
            <div class="col-md-6 form-group">
              <label class="form-label">{{ __('email') }} <span class="text-danger">*</span></label>
              <input class="form-control" type="email" name="email" data-name="email" placeholder="{{ __('email') }}">
              <span class="help-block" style="">

              </span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group" dir="ltr">
              <label class="form-label">{{ __('phone') }}</label>
              <input class="form-control" type="text" name="mobile" id="mobile" data-name="mobile" placeholder="{{ __('phone') }}">
              <span class="help-block" style="">

              </span>
            </div>
            <div class="form-group">
              <label class="form-label">{{ __('Message') }} <span class="text-danger">*</span></label>
              <textarea class="form-control" name="desc" data-name="desc" placeholder="Message"></textarea>
              <span class="help-block" style="">

              </span>
            </div>
            <div class="text-center">
              <button class="btn theme-btn form-group" type="submit">{{ __('Send Message') }}</button>
              <p class="text-muted">{{ __('We\'ll get back to you in 1-2 business days.') }}</p>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>


  @endsection
