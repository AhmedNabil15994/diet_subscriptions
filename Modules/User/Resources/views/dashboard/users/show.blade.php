@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.show.title'))
@section('css')
  <style>
    .modal .form-group{
      margin-bottom: 20px;
    }
    input[type="radio"][value="1"]{
      margin-bottom: 10px;
    }
    .dates{
      display: none;
    }
    .portlet.light .dataTables_wrapper .dt-buttons{
      margin-top: 0;
      @if(locale() == 'ar')
        float:right !important;
       @endif
    }
  </style>
@endsection
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
                    <a href="{{ url(route('dashboard.users.index')) }}">
                        {{__('user::dashboard.users.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('user::dashboard.users.show.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
          @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
          @endif
{{--                 {!! Form::model($model,[--}}
{{--                                    'url'=> route('dashboard.users.update',$model->id),--}}
{{--                                    'id'=>'updateForm',--}}
{{--                                    'role'=>'form',--}}
{{--                                    'method'=>'PUT',--}}

{{--                                    'class'=>'form-horizontal form-row-seperated',--}}
{{--                                    'files' => true--}}
{{--                                    ])!!}--}}


                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable"
                            id="accordion2">
                            <div class="panel panel-default">

                                <div id="collapse_2_1"
                                    class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#global_setting"
                                                    data-toggle="tab">
                                                    {{ __('user::dashboard.users.update.form.general') }}
                                                </a>
                                            </li>
                                          <li class="">
                                            <a href="#subscriptions"
                                               data-toggle="tab">
                                              {{ __('user::dashboard.users.show.form.subscriptions') }}
                                            </a>
                                          </li>
                                          <li class="">
                                            <a href="#suspensions"
                                               data-toggle="tab">
                                              {{ __('user::dashboard.users.show.form.suspensions') }}
                                            </a>
                                          </li>
                                          <li class="">
                                            <a href="#transactions"
                                               data-toggle="tab">
                                              {{ __('user::dashboard.users.show.form.transactions') }}
                                            </a>
                                          </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in"
                                id="global_setting">
                                <div class="col-md-10">
                                    @include('user::dashboard.users.form.form')
                                    @if($model->code_verified == null)
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3" style="padding: 3px">
                                      <a href="{{url(route('dashboard.users.sendOTP',['id'=>$model->id])) }}"
                                         class="btn btn-md mx-10">
                                        <i class="fa fa-envelope"></i>
                                        {{__('apps::dashboard.buttons.sendOTP')}}
                                      </a>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="subscriptions">
                              <div class="col-md-12">
                                @include('user::dashboard.users.components.subscriptions')
                              </div>
                            </div>

                            <div class="tab-pane fade" id="suspensions">
                              <div class="col-md-12">
                                @include('user::dashboard.users.components.suspensions')
                              </div>
                            </div>

                            <div class="tab-pane fade" id="transactions">
                              <div class="col-md-12">
                                @include('user::dashboard.users.components.transactions')
                              </div>
                            </div>

                            {{-- END UPDATE FORM --}}
                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit"
                                    id="submit"
                                    class="btn btn-lg green">
                                    {{__('apps::dashboard.buttons.edit')}}
                                </button>
                                <a href="{{url(route('dashboard.users.index')) }}"
                                    class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
{{--            </form>--}}
        </div>
    </div>
</div>
  @include('user::dashboard.users.components.suspendModal')
@stop

@push('start_scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js" integrity="sha512-Z/2pIbAzFuLlc7WIt/xifag7As7GuTqoBbLsVTgut69QynAIOclmweT6o7pkxVoGGfLcmPJKn/lnxyMNKBAKgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js" integrity="sha512-t3XNbzH2GEXeT9juLjifw/5ejswnjWWMMDxsdCg4+MmvrM+MwqGhxlWeFJ53xN/SBHPDnW0gXYvBx/afZZfGMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    $(function (){
      $(document).on('click','.openSuspendModal',function (e){
        e.preventDefault();
        e.stopPropagation();
        let id = $(this).data('area');
        $.ajax({
          type: "GET",
          url: "{{route('dashboard.users.getActiveSubscriptions',['id' => ':id'])}}".replace(':id',id),
          data: {
            '_token'  : $('meta[name="csrf-token"]').attr('content'),
          },
          success:function (data){
            let x = '';
            $('#suspendModal .subscriptions').empty()
            $('#suspendModal input,#suspendModal textarea').val('');
            $('#suspendModal input').attr('min','');
            $.each(data.subscriptions,function (index,item){
              let subscription = '{{__('user::dashboard.users.index.subscription',['subscription' => ':number'])}}'.replace(':number',item.id);
              let package = '{{__('user::dashboard.users.index.package',['package' => ':packageName'])}}'.replace(':packageName',item.package_id);
              x+= '<div class="row" style="margin-bottom: 10px">' +
                '<div class="col-xs-1">' +
                `<input type="radio" style="width: 15px;height: 15px" class="form-control" data-area="${item.start_at}" name="subscription_id" value="${item.id}">`+
                '</div>' +
                '<div class="col-xs-8">' +
                subscription+ "<br>"+
                package+ "<br>"+
                `(${item.start_at + ' - ' + item.end_at})`+
                '</div>'+
                '</div>';
            });

            $('#suspendModal .subscriptions').append(x)
            $('#suspendModal .pause_subscription').data('area',id)
            $('#suspendModal').modal('show')
          },
          error: function (error){
            $('#suspendModal .subscriptions').empty()
            $('#suspendModal input,#suspendModal textarea').val('');
            $('#suspendModal input').attr('min','');
          }
        })
      });

      $(document).on('change','input[name="subscription_id"]',function (){
        $('.dates input').attr('min',$(this).data('area'));
        $('.dates').show()
      });
    });
  </script>
@endpush
