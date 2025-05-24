<div class="modal fade" id="suspendModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{__('user::dashboard.users.index.suspend_subscription')}}</h5>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <div class="col-xs-4">{{__('user::dashboard.users.index.active_subscriptions')}}</div>
          <div class="col-xs-8 subscriptions"></div>
        </div>
        <div class="dates">
          <div class="form-group row">
            <div class="col-xs-4">{{__('user::dashboard.users.index.stop_start_date')}}</div>
            <div class="col-xs-8">
              <input type="date" min="" class="form-control" name="start_at">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-xs-4">{{__('user::dashboard.users.index.stop_end_date')}}</div>
            <div class="col-xs-8">
              <input type="date" min="" class="form-control" name="end_at">
              <p style="margin: 0;margin-top: 5px">{{__('user::dashboard.users.index.stop_end_date_p')}} </p>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-xs-4">{{__('user::dashboard.users.index.notes')}}</div>
            <div class="col-xs-8">
              <textarea name="notes" class="form-control" cols="30" rows="10"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pause_subscription"> {{__('apps::dashboard.buttons.add')}}</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('apps::dashboard.buttons.cancel')}}</button>
      </div>
    </div>
  </div>
</div>
