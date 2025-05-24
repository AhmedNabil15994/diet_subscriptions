@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.register.index.title') )
@section( 'content')
<div class="inner-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-5">
        <div class="login">
          <h2> {!! _('Welcome To ') !!}<b>{{ setting('app_name',locale()) }}</b></h2>
          <p>{{ __('Fill out the form to get started.') }}</p>
          {!! Form::open([
          'url'=> route('frontend.auth.register.post'),
          'method'=>'POST',
          'class'=>'login-form active',
          'files' => true,
          'id'=>'registerForm',
          'novalidate'=>'true'
          ])!!}


          <input type="hidden" name="try_verified" id="try_verified" value="">
          <div class="form-group can-hidden">
            <input type="text" class="form-control" name="name" placeholder="{{ __('name') }}">
          </div>
          <div class="form-group can-hidden">
            <input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}">
          </div>
          <div class="form-group" dir="ltr">
            <input type="text" name="mobile" id="mobile" data-name="mobile" class="form-control" placeholder="{{ __('mobile') }}">
            <input type="hidden" name="mobile_country" id="mobile_country" value="kw">
          </div>
          <div class="form-group position-relative  can-hidden">
            <i class="position-absolute fas eye-slash" id="showPass"></i>
            <input type="password" id="passInput" autocomplete="new-password" class="form-control" name="password" placeholder="{{ __('Password') }}">
          </div>


          <div class="form-group position-relative code-filed" hidden>
            <label for="passInput">{{ __('write recived code here') }}</label>
            <input type="string" class="form-control" name="code_verified" placeholder="{{ __('code') }}">
          </div>

          <div class="form-group position-relative can-hidden">
            <i class="position-absolute fas eye-slash" id="showPass2"></i>
            <input type="password" id="passInput2" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
          </div>
          
          <button class="btn theme-btn btn-block form-group" type="submit">{{ __('Create an account') }}</button>
          </form>
          <div class="mt-40 text-center">
            <span class="text-muted d-block mb-10">{{ __('Already have an account?') }}</span>
            <a class="btn theme-btn-sec btn-block" href="{{ route('frontend.auth.login') }}">{{ __('Login In') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('js')
<script>
  $('#registerForm').on('submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    $.ajax({
        url: url,
        type: method,
        dataType: 'JSON',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $('#submit').prop('disabled', true);
            resetErrors();
        },
        success: function (data) {
            $('#submit').prop('disabled', false);
            $('#mobile').prop('disabled', true);
            $('#submit').text();
            $('.can-hidden').each(function (index, element) {
                      $(element).hide()
            });
            if (data[0] == true) {
                redirect(data);
                successfully(data);
                $('.code-filed').attr('hidden',false)
                $('#try_verified').val(data['try_verified'])

            } else {
                displayMissing(data);
            }
            ;
        },
        error: function (data) {
            $('#submit').prop('disabled', false);
            displayErrors(data);
        },
    });

});
</script>
@endpush
