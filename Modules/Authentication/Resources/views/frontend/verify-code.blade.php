@extends('apps::frontend.layouts.app')
@section('title', __('authentication::frontend.register.index.title') )
@section( 'content')
<div class="inner-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-5">
        <div class="login">
          <h2> {!! _('Welcome To ') !!}<b>{{ setting('app_name',locale()) }}</b></h2>
          <p>{{ __('verify you\'r account') }}</p>
          {!! Form::open([
          'url'=> route('frontend.auth.verify.post'),
          'method'=>'POST',
          'class'=>'login-form active',
          'novalidate'=>'true'
          ])!!}
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="{{ __('code') }}">
          </div>
          <button class="btn theme-btn btn-block form-group" type="submit">{{ __('Verify') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
