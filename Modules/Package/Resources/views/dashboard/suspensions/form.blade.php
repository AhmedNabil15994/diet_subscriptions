<div class="form-group">
  <label for="subscription_id" class="col-md-2">{{__('package::dashboard.suspensions.form.user')}}</label>
  <div class="col-md-9">
    <select class="form-control select2" name="subscription_id" id="subscription_id">
      <option value="">{{__('package::dashboard.suspensions.form.user')}}</option>
      @foreach($extraData['subscriptions'] as $subscription)
        <option value="{{$subscription->id}}" {{$subscription->user->user_id == $model->user_id ? 'selected' : ''}}> {{$subscription->user->mobile . ' - ' . $subscription->user->name}} </option>
      @endforeach
    </select>
  </div>
</div>

<div class="subscription-information">

</div>
{!! field()->date('start_at',__('package::dashboard.suspensions.form.start_at')) !!}
{!! field()->date('end_at',__('package::dashboard.suspensions.form.end_at')) !!}
{!! field()->textarea('notes',__('package::dashboard.suspensions.form.notes'),$model->notes,['class'=>'form-control']) !!}



@push('scripts')
<script>
  $('#subscription_id').change(function(){
        $.ajax({
          type: "get",
          url: "{{ route('dashboard.subscriptions.getSubscriptionById',':id') }}".replace(":id",$(this).val()),
          success: function (response) {
              $('.subscription-information').html(`
                  <h5>{{ __('package::dashboard.suspensions.form.start_at') }} : ${response['start_at']}</h5>
                  <h5>{{ __('package::dashboard.suspensions.form.end_at') }} : ${response['end_at']}</h5>
              `)
          }
        });
      })
</script>
@endpush
