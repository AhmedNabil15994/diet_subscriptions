@extends('apps::frontend.layouts.app')
@section('title', __('Welcome To') )
@section('content')
<div class="inner-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-5">
        <div class="login">
          <h2> {!! __('Welcome To') !!}
            <b>{{ setting('app_name',locale()) }}</b>
          </h2>

          {!! Form::open([
          'url'=> route('frontend.auth.login.post'),
          'method'=>'POST',
          'id'=>'loginForm',
          'class'=>'login-form',
          'files' => true,
          'novalidate'=>"true"
          ])!!}
          <input type="hidden" name="new_user" id="new_user" value="null">
          <div class="form-group" dir="ltr">
            <input type="text" name="mobile" id="mobile" data-name="mobile" class="form-control" placeholder="{{ __('mobile') }}">
            <input type="hidden" name="mobile_country" id="mobile_country" value="kw">
            <span class="help-block"></span>
          </div>
          <div class="form-group position-relative password-filed" hidden>
            <label for="passInput" class="py-2">{{ __('write recived code here') }}</label>
            <input type="string" id="passInput" class="form-control" name="code_verified" placeholder="{{ __('code') }}">
          </div>

          <div class="form-group new_user-filed" hidden>
            <input type="text" class="form-control" name="name" placeholder="{{ __('name') }}">
          </div>

          <button class="btn theme-btn btn-block form-group" id="submit" type="submit">{{ __('continue') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection









@push('js')
<script>
  $('#loginForm').on('submit', function (e) {
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
            // $('#submit').prop('disabled', true);
            resetErrors();
        },
        success: function (data) {
          if( 'new_user' in data){
             $('#new_user').val(data['new_user'])
              $('.new_user-filed').attr('hidden',false)
          }
            $('#submit').prop('disabled', false);
            $('#mobile').prop('disabled', true);
            $('#submit').text();

            if (data[0] == true) {
                redirect(data);
                successfully(data);
                $('.password-filed').attr('hidden',false)

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
