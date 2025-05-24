<div class="row">
  <div class="col-md-12">
      <div class="portlet light bordered">
        <div class="portlet-title">
          <div class="col-xs-12">
            <div class="col-xs-6">
              <div class="caption font-dark">
                <i class="icon-settings font-dark"></i>
                <span class="caption-subject bold uppercase">
                  {{ __('package::dashboard.suspensions.routes.index') }}
                </span>
              </div>
            </div>
            <div class="col-xs-6 text-right">
              @can('add_suspensions')
                <div class="table-toolbar">
                  <div class="btn-group">
                    <a data-area="{{$model->id}}"  title="Suspend Subscriptions"
                       class="btn sbold openSuspendModal green">
                      <i class="fa fa-plus"></i> {{ __('apps::dashboard.buttons.add_new') }}
                    </a>
                  </div>
                </div>
              @endcan
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      {{-- DATATABLE CONTENT --}}
      <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover"
               id="suspension_dataTable">
          <thead>
          <tr>
            <th>#</th>
            <th>{{ __('package::dashboard.suspensions.datatable.package') }}</th>
            <th>{{ __('package::dashboard.suspensions.datatable.start_at') }}</th>
            <th>{{ __('package::dashboard.suspensions.datatable.end_at') }}</th>
            <th>{{ __('package::dashboard.suspensions.datatable.created_at') }}</th>
          </tr>
          </thead>
        </table>
      </div>
      </div>
  </div>
</div>
