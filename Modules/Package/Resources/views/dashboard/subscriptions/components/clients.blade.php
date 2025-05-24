@inject('users','Modules\User\Entities\User')
<div class="hide-inputs" id="chose-input">
  <select class="form-control select2" name="user_id" id="user_id">
    <option value="">{{__('User')}}</option>
    @foreach($users->get() as $user)
      <option value="{{$user->id}}" {{$model->user_id == $user->id ? 'selected' : ''}}> {{$user->mobile . ' - ' . $user->name}} </option>
    @endforeach
  </select>
</div>

<div class="hide-inputs" id="create-input" style="display: none">

    {!! field()->text('user_name', __('Name')) !!}
    {!! field()->number('user_mobile', __('Mobile')) !!}
</div>
@push('scripts')
    <script>
        $('input[name=client_type]').change(function () {
            $('.hide-inputs').hide();
            $('#' + this.value + '-input').show();
        })
    </script>
@endpush
