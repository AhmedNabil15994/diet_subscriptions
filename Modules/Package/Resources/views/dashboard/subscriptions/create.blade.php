@extends('apps::dashboard.layouts.app')
@section('title', __('package::dashboard.subscriptions.routes.create'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.subscriptions.index')) }}">
                        {{__('package::dashboard.subscriptions.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('package::dashboard.subscriptions.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            {!! Form::model($model,[
                           'url'=> route('dashboard.subscriptions.store'),
                           'id'=>'form',
                           'role'=>'form',
                           'method'=>'POST',
                           'class'=>'form-horizontal form-row-seperated',
                           'files' => true
                           ])!!}

                <div class="col-md-6 ">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">
                                    {{ __('package::dashboard.packages.form.tabs.general') }}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                                <div class="form-body">
                                    @include('package::dashboard.subscriptions.form')
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 ">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{__('User')}}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2">
                            </label>

                            <div class="col-md-9">
                                <div class="md-radio-inline">
                                    <label class="mt-radio" style="margin: 0px 25px;">
                                        <input type="radio" name="client_type" id="type" value="chose"
                                               checked="checked">
                                        {{__('Chose user')}}
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        <input type="radio" name="client_type" id="type" value="create">
                                        {{__('Create user')}}
                                        <span></span>
                                    </label>

                                </div>
                                <div class="help-block"></div>
                            </div>
                        </div>
                        <div class="portlet-body form">
                                <div class="form-body">
                                    @include('package::dashboard.subscriptions.components.clients')
                                </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="col-md-12">
                        {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{__('apps::dashboard.buttons.add')}}
                                </button>
                                <a href="{{url(route('dashboard.subscriptions.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            {!! Form::close()!!}
        </div>
    </div>
</div>
@stop
