<div class="row">
  <div class="col-md-12">
        <div class="portlet light bordered">

          <div class="portlet-title">
            <div class="caption font-dark">
              <i class="icon-settings font-dark"></i>
              <span class="caption-subject bold uppercase">
                {{ __('package::dashboard.subscriptions.routes.index') }}
              </span>
            </div>
          </div>

          {{-- DATATABLE FILTER --}}
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
                            <div class="form-group" style="margin:0; ">
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
                            <div class="form-group" style="margin:0; ">
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
                          <div class="col-md-3">
                            <label class="control-label">
                              {{__('package::dashboard.subscriptions.datatable.can_order_in')}}
                            </label>
                            <input type="date" class="form-control" name="can_order_in" value="{{isset($can_order_in_date) ? $can_order_in_date : Carbon\Carbon::now()->addDay()->toDateString()}}">
                          </div>
                          <div class="col-md-3">
                            <label class="control-label" style="margin: 20px">
                              {{__('package::dashboard.subscriptions.datatable.is_default')}}
                            </label>
                            <input placeholder="default package" class="switch-btn filter-datatable" data-size="small" data-name="is_default" id="is_default" name="is_default" type="checkbox">
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="form-actions" style="margin-top: 10px">
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
          {{-- END DATATABLE FILTER --}}

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
                  <th>#</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.package') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.is_default') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.is_free') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.price') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.start_at') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.end_at') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.pause') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.permanent_pause_days') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.coupon') }}</th>
                  <th>{{ __('package::dashboard.subscriptions.datatable.note') }}</th>
                  <th >{{ __('package::dashboard.subscriptions.datatable.mobile') }}</th>
                  <th >{{ __('package::dashboard.subscriptions.datatable.address') }}</th>
                  <th data-priority="1">
                    {{ __('package::dashboard.subscriptions.datatable.options') }}
                  </th>
                </tr>
              </thead>
            </table>
          </div>
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

@section('scripts')
  <script>
    function tableTransactionsGenerate(data='') {
      var transactions_dataTable =
        $('#transactions_dataTable').DataTable({
          ajax : {
            url   : "{{ url(route('dashboard.transactions.datatable')) }}?client_id={{$model->id}}",
            type  : "GET",
            data  : {
              req : data,
            },
          },
          language: {
            url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 0 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
            {data: 'payment_id' 			, className: 'dt-center'},
            {data: 'method' 			    , className: 'dt-center'},
            {data: 'result' 			    , className: 'dt-center'},
            {data: 'client_name' 			    , className: 'dt-center'},
            {data: 'client_mobile' 			    , className: 'dt-center'},
            {data: 'track_id' 			  , className: 'dt-center'},
            {data: 'type' 			      , className: 'dt-center' , orderable: false},
            {data: 'ref' 			        , className: 'dt-center'},
            {data: 'created_at' 		  , className: 'dt-center'},
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
              exportOptions: {
                stripHtml : false,
                columns: ':visible',
                columns: [ 1 , 2 , 3 , 4 ,5 ,6 ,7]
              }
            },
            {
              extend: "print",
              className: "btn blue btn-outline" ,
              text: "{{__('apps::dashboard.datatable.print')}}",
              exportOptions: {
                stripHtml : false,
                columns: ':visible',
                columns: [ 1 , 2 , 3 , 4 ,5 ,6 ,7]
              }
            },
            {
              extend: "excel",
              className: "btn blue btn-outline " ,
              text: "{{__('apps::dashboard.datatable.excel')}}",
              exportOptions: {
                stripHtml : false,
                columns: ':visible',
                columns: [ 1 , 2 , 3 , 4 ,5 ,6 ,7]
              }
            },
            {
              extend: "colvis",
              className: "btn blue btn-outline",
              text: "{{__('apps::dashboard.datatable.colvis')}}",
              exportOptions: {
                stripHtml : false,
                columns: ':visible',
                columns: [ 1 , 2 , 3 , 4 ,5 ,6 ,7]
              }
            }
          ]
        });
    }

    function tableSuspensionsGenerate(data='') {

      var suspension_dataTable =
        $('#suspension_dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
            if ( data["deleted_at"] != null ) {
              $(row).addClass('danger');
            }
          },
          ajax : {
            url   : "{{ url(route('dashboard.suspensions.datatable')) }}?client_id={{$model->id}}",
            type  : "GET",
            data  : {
              req : data,
            },
          },
          language: {
            url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 0 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
            {data: 'package' 			      , className: 'dt-center'},
            {data: 'start_at' 	        , className: 'dt-center' ,},
            {data: 'end_at' 	        , className: 'dt-center' ,},
            {data: 'created_at' 		  , className: 'dt-center'},
          ],
          columnDefs: [

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

    function tableGenerate(data='') {

      var dataTable =
        $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
            if ( data["deleted_at"] != null ) {
              $(row).addClass('danger');
            }
          },
          ajax : {
            url   : "{{ url(route('dashboard.subscriptions.datatable')) }}?client_id={{$model->id}}",
            type  : "GET",
            data  : {
              req : data,
            },
          },
          language: {
            url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
            {data: 'id' 		 	        , className: 'dt-center'},
            {data: 'package_id' 			      , className: 'dt-center'},
            {data: 'is_default' , className: 'dt-center' , render: function(data, type, row){
                return data? '<div class="text-center"><i class="fa fa-check"></i></div>':
                  '<div class="text-center"> <i class="fa fa-close"></i> </div>'

              }},
            // {data: 'from_admin' , className: 'dt-center' ,
            // render: function(data, type, row){
            // return data? '<div class="text-center"><i class="fa fa-check"></i></div>':
            //       '<div class="text-center"> <i class="fa fa-close"></i> </div>'
            // }
            // },
            {data: 'is_free' 	        , className: 'dt-center' , render: function(data, type, row){
                return data? '<div class="text-center"><i class="fa fa-check"></i></div>':
                  '<div class="text-center"> <i class="fa fa-close"></i> </div>'

              }},

            {data: 'price' 		  , className: 'dt-center'},
            {data: 'start_at' 		  , className: 'dt-center'},
            {data: 'end_at' 		  , className: 'dt-center'},
            {data: 'is_pause' 		  ,orderable: false , className: 'dt-center'},
            {data: 'permanent_pause_days' 		  , orderable: false , className: 'dt-center'},
            {data: 'coupon' 		  ,orderable: false , className: 'dt-center'},
            {data: 'note' 		  , orderable: false , className: 'dt-center'},
            {data: 'mobile' 		  , orderable: false , className: 'dt-center'},
            {data: 'address' 		  ,orderable: false , className: 'dt-center'},
            {data: 'id'},
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

            {
              targets: -1,
              responsivePriority: 1,
              width: '13%',
              title: '{{__('package::dashboard.subscriptions.datatable.options')}}',
              className: 'dt-center',
              orderable: false,
              render: function(data, type, full, meta) {

                // Edit
                var editUrl = '{{ route("dashboard.subscriptions.permanentSuspension", ":id") }}';
                editUrl = editUrl.replace(':id', data);
                let add_suspensions = `
                @can('add_suspensions')
                <a href="`+editUrl+`" class="btn btn-sm blue" title="Subscription Permanent Suspension">
                            <i class="fa fa-clock-o"></i> {{__('package::dashboard.subscriptions.datatable.permanent_pause')}}
                          </a>
                  @endcan`;
                if(full.permanent_pause_days && full.pause_end_at == null){
                  add_suspensions = ``;
                }

                return add_suspensions;
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
      $('.switch-btn').bootstrapSwitch({
        onSwitchChange: function (e, state) {
          let form = $("#formFilter");
          let data = getFormData(form);
          $("#dataTable").DataTable().destroy();
          tableGenerate(data);
        }
      });

      tableGenerate();
      tableSuspensionsGenerate();
      tableTransactionsGenerate();

      $('#collapse_2_1 li').on('click',function (){
        $('input[name="from"],input[name="to"],input[name="can_order_in"],input[name="status"],input[name="deleted"]').val('')
        if($(this).find('a[href="#subscriptions"]').length){
          $('.filter-submit').trigger('click')
        }
      })

      @can('add_suspensions')
      $(document).on('click','.pause_subscription',function (e){
        e.preventDefault();
        e.stopPropagation();
        let dataObj = {
          '_token'  : $('meta[name="csrf-token"]').attr('content'),
          'user_id'        : $(this).data('area'),
          'subscription_id': $('input[name="subscription_id"]').val(),
          'start_at'       : $('input[name="start_at"]').val(),
          'end_at'         : $('input[name="end_at"]').val(),
          'notes'          : $('textarea[name="notes"]').val(),
        }
        $.ajax({
          type: "POST",
          url: "{{route('dashboard.users.pauseActiveSubscriptions')}}",
          data: dataObj,
          success:function (data){
            if(data[0]){
              toastr.success(data[1]);
              $('#suspendModal').modal('hide')
              $("#suspension_dataTable").DataTable().ajax.reload();
            }else{
              toastr.error(data[1]);
            }
          },
          error: function (error){
            console.log(error)
          }
        })
      });
      @endcan
    });
  </script>
@endsection
