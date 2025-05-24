@extends('apps::dashboard.layouts.app')
@section('title', __('package::dashboard.subscriptions.routes.index'))
@section("css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.min.css" integrity="sha512-TsNN9S3X3jnaUdLd+JpyR5yVSBvW9M6ruKKqJl5XiBpuzzyIMcBavigTAHaH50MJudhv5XIkXMOwBL7TbhXThQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/easy-autocomplete.themes.min.css" integrity="sha512-5EKwOr+n8VmXDYfE/EObmrG9jmYBj/c1ZRCDaWvHMkv6qIsE60srmshD8tHpr9C7Qo4nXyA0ki22SqtLyc4PRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.css" integrity="sha512-zrPsLVYkdDha4rbMGgk9892aIBPeXti7W77FwOuOBV85bhRYi9Gh+gK+GWJzrUnaCiIEm7YfXOxW8rzYyTuI1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .item-barcode{
        display: flex;
        justify-content: center;
        align-items: flex-end;
        width: 100%;
    }
    .barcode{
        border: 1px dashed #000;
        padding: 8px 0px;
    }
    .printer-container{
        /* border: 1px solid #000 */
    }
    .label-border-outer{
        border: 1px solid #000
    }
    .label-border-internal{
        display: flex  !important;
        flex-wrap: wrap
        
    }
    .label-print{
        display: inline-block;
        border: 1px dashed gray !important;
        color:#000;
        -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
        -moz-box-sizing: border-box;    /* Firefox, other Gecko */
        box-sizing: border-box;         /* Opera/IE 8+ */
    }
    .label-print .items{
       height: inherit;
       padding: 5px 0;
       display: flex;
       align-items: flex-end;
       flex-wrap: wrap
       
    }
    .page-break  {

        page-break-after:always;
    }
    /* ============ ============ */
    @media print {
        .label , .label-print, .barcode{
              
                border: none !important
        }
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                float: left;
        }
        .col-sm-12 {
                width: 100%;
        }
        .col-sm-11 {
                width: 91.66666667%;
        }
        .col-sm-10 {
                width: 83.33333333%;
        }
        .col-sm-9 {
                width: 75%;
        }
        .col-sm-8 {
                width: 66.66666667%;
        }
        .col-sm-7 {
                width: 58.33333333%;
        }
        .col-sm-6 {
                width: 50%;
        }
        .col-sm-5 {
                width: 41.66666667%;
        }
        .col-sm-4 {
                width: 33.33333333%;
        }
        .col-sm-3 {
                width: 25%;
        }
        .col-sm-2 {
                width: 16.66666667%;
        }
        .col-sm-1 {
                width: 8.33333333%;
        }
        .barcode-image img {
            width: 70% !important;
        }
        .item-barcode{
            text-align: center;
            
        }
        .printButton{
            display: none !important;
        }
        #printer{
            border: none !important;
            overflow: hidden !important;
        }
}

</style>
@stop
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
          <a href="#">{{ __('package::dashboard.subscriptions.routes.index') }}</a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">

          {{-- @can('add_subscriptions')
          <div class="table-toolbar">
            <div class="row">
              <div class="col-md-6">
                <div class="btn-group">
                  <a href="{{ url(route('dashboard.subscriptions.create')) }}"
                    class="btn sbold green">
                    <i class="fa fa-plus"></i> {{ __('apps::dashboard.buttons.add_new') }}
                  </a>
                </div>
              </div>
            </div>
          </div>
          @endcan --}}


          {{-- DATATABLE FILTER --}}
          <div class="row">
            <div class="portlet box grey-cascade">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-gift"></i>
                  {{ __('apps::dashboard.datatable.search') }}
                </div>
                <div class="tools">
                  <a href="javascript:;"
                    class="collapse"
                    data-original-title=""
                    title=""> </a>
                </div>
              </div>
              <div class="portlet-body">
                <div id="filter_data_table">
                  <div class="panel-body">
                    <form id="formFilter"
                      class="horizontal-form">
                      <div class="form-body">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="control-label">
                                {{ __('apps::dashboard.datatable.form.date_range') }}
                              </label>
                              <div id="reportrange"
                                class="btn default form-control">
                                <i class="fa fa-calendar"></i> &nbsp;
                                <span> </span>
                                <b class="fa fa-angle-down"></b>
                                <input type="hidden"
                                  name="from">
                                <input type="hidden"
                                  name="to">
                              </div>
                            </div>
                          </div>
                            
                          <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">
                                    {{__('package::dashboard.subscriptions.datatable.package')}}
                                </label>
                                <select name="package_id"
                                    id="single"
                                    class="form-control select2">
                                    <option value="">
                                        all
                                    </option>
                                    @foreach ($packages as $package)
                                      <option value="{{ $package->id }}">
                                          {{ $package->title }}
                                      </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                          @include('package::dashboard.subscriptions.filter')
                        </div>
                      </div>
                    </form>
                    <div class="form-actions">
                      <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                        id="search">
                        <i class="fa fa-search"></i>
                        {{ __('apps::dashboard.datatable.search') }}
                      </button>
                      <button class="btn btn-sm red btn-outline filter-cancel">
                        <i class="fa fa-times"></i>
                        {{ __('apps::dashboard.datatable.reset') }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <x-dashboard-package-count :packages="$packages" subscriptionrelation="to_day"/>
          
          {{-- END DATATABLE FILTER --}}

          <div class="portlet-title">
            <div class="caption font-dark">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject bold uppercase">
                {{ __('package::dashboard.subscriptions.routes.index') }}
              </span>
            </div>
          </div>

          {{-- DATATABLE CONTENT --}}
          <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover"
              id="dataTable">
              <thead>
                <tr>
                  <th>
                    <a href="javascript:;"
                      onclick="CheckAll()">
                      {{ __('apps::dashboard.buttons.select_all') }}
                    </a>
                  </th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.package') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.user') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.start_at') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.end_at') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.pause') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.note') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.mobile') }}</th>
                  <th data-priority="1">
                    {{ __('package::dashboard.subscriptions.datatable.address') }}
                  </th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="row">
            <div class="form-group">
              <button type="submit"
                id="deleteChecked"
                class="btn red btn-sm"
                onclick="deleteAllChecked('{{ url(route('dashboard.subscriptions.deletes')) }}')">
                {{ __('apps::dashboard.datatable.delete_all_btn') }}
              </button>
              <select class="form-control" name="print_setting_id" id="print_setting_id" style="width: 133px;display: inline;">
                @inject('print_settings','Modules\Package\Entities\PrintSetting')
                @foreach ($print_settings->get() as  $item)
                     <option
                        value="{{$item->id}}"
                     >{{$item->name}}</option>
                @endforeach
                
              </select>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body" style="display:none">
                      <div id="printer"></div>
                  </div>
              <button 
                type="button"
                class="btn btn-info btn-sm" id="print_btn"
                onclick="printAllChecked('{{ url(route('dashboard.subscriptions.print')) }}')">
                {{__('apps::dashboard.datatable.print')}}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop


@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js" integrity="sha512-Z/2pIbAzFuLlc7WIt/xifag7As7GuTqoBbLsVTgut69QynAIOclmweT6o7pkxVoGGfLcmPJKn/lnxyMNKBAKgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js" integrity="sha512-t3XNbzH2GEXeT9juLjifw/5ejswnjWWMMDxsdCg4+MmvrM+MwqGhxlWeFJ53xN/SBHPDnW0gXYvBx/afZZfGMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route(isset($datatableRoute) ? $datatableRoute : 'dashboard.subscriptions.today_orders.datatable')) }}",
              type  : "GET",
              data  : {
                  req : data,
              },
          },
          language: {
              url:"https://cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
      			{data: 'package_id' 			      , className: 'dt-center'},
            {data: 'user_id' 	        , className: 'dt-center'},
            {data: 'start_at' 		  , className: 'dt-center'},
            {data: 'end_at' 		  , className: 'dt-center'},
            {data: 'is_pause' 		  , orderable: false , className: 'dt-center'},
            {data: 'note' 		  , orderable: false , className: 'dt-center'},
            {data: 'mobile' 		  , orderable: false , className: 'dt-center'},
            {data: 'address',orderable: false ,className: 'dt-center',responsivePriority: 1},
      		],
          columnDefs: [
            {
      				targets: 0,
      				width: '30px',
      				className: 'dt-center',
      				orderable: false,
      				render: function(data, type, full, meta) {
      					return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="${data}" class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
      				},
      			},
          ],
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50 , 100 , 500 ],
              [ '10', '25', '50', '100' , '500']
          ],
  				buttons:[
  					{
    						extend: "pageLength",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.pageLength')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4, 6, 7]
                }
  					},
  					{
    						extend: "print",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.print')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4, 6, 7]
                }
  					},

  					{
  							extend: "excel",
                className: "btn blue btn-outline " ,
                text: "{{__('apps::dashboard.datatable.excel')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4, 6, 7]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.colvis')}}",
                eexportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4, 5 , 6, 7]
                }
  					}
  				]
      });
  }

  jQuery(document).ready(function() {
  	tableGenerate();
  });
</script>

@stop
