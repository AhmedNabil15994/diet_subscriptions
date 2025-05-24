<div class="row">
  <div class="col-md-12">
    <div class="portlet light bordered">

      <div class="portlet-title">
        <div class="caption font-dark">
          <i class="icon-settings font-dark"></i>
          <span class="caption-subject bold uppercase">
              {{__('transaction::dashboard.transactions.index.title')}}
          </span>
        </div>
      </div>

      {{-- DATATABLE CONTENT --}}
      <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover"
               id="transactions_dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{__('transaction::dashboard.transactions.datatable.payment_id')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.method')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.result')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.client_name')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.client_mobile')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.track_id')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.type')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.ref')}}</th>
              <th>{{__('transaction::dashboard.transactions.datatable.created_at')}}</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
