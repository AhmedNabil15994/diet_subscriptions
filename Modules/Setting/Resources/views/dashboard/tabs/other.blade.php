<div class="tab-pane fade" id="other">
  <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.other') }}</h3>
  <div class="col-md-10">
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.about_us') }}
      </label>
      <div class="col-md-9">
        <select name="other[about_us]" id="single" class="form-control select2">
          <option value=""></option>
          @foreach ($pages as $page)
          <option value="{{ $page['id'] }}" {{( setting('other','about_us')==$page->id) ? ' selected="" ' : ''}}>
            {{ $page->title }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.privacy_policy') }}
      </label>
      <div class="col-md-9">
        <select name="other[privacy_policy]" id="single" class="form-control select2">
          <option value=""></option>
          @foreach ($pages as $page)

          <option value="{{ $page['id'] }}" {{( setting('other','privacy_policy')==$page->id) ? ' selected="" ' : ''}}>
            {{ $page->title }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.terms') }}
      </label>
      <div class="col-md-9">
        <select name="other[terms]" id="single" class="form-control select2">
          <option value=""></option>
          @foreach ($pages as $page)
          <option value="{{ $page['id'] }}" {{(setting('other','terms')==$page->id) ? ' selected="" ' : ''}}>
            {{ $page->title }}
          </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.max_suspension') }}
      </label>

      <div class="col-md-9">
        <input type="number" class="form-control" name="max_suspension" value="{{ setting('max_suspension')  }}" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2">
        {{ __('setting::dashboard.settings.form.max_renew_with_same_price') }}
      </label>
      <div class="col-md-9">
        <input type="number" class="form-control" name="max_renew_with_same_price" value="{{ setting('max_renew_with_same_price')  }}" />
      </div>
    </div>

    <h5 class="page-title">{{ __('get orders') }}</h5>
    <div class="form-group">
      <label class="col-md-2">
          {{ __('get orders') }}
      </label>
      <div class="col-md-9">
          <div class="mt-radio-inline">
              <label class="mt-radio mt-radio-outline">
                  {{ __('Yes') }}
                  <input type="radio" name="other[selling_on_site]" value="1"
                  {{(setting('other','selling_on_site') ?? 1) == 1 ? 'checked' : ''}}
                  >
                  <span></span>
              </label>
              <label class="mt-radio mt-radio-outline">
                  {{ __('No') }}
                  <input type="radio" name="other[selling_on_site]" value="0"
                      @if ((setting('other','selling_on_site') ?? 1) == 0) checked @endif>
                  <span></span>
              </label>
          </div>
      </div>
    </div>

    {!! field()->number('other[max_orders]',__('maxmum orders'),setting('other','max_orders') ?? null) !!}
    {!! field()->date('other[max_orders_start_at]',__('Start count maxmum orders'),setting('other','max_orders_start_at') ?? null) !!}

    {!! field()->number('other[current_orders_counted]',__('Current orders counted'),setting('other','current_orders_counted') ?? 0) !!}
    {!! field()->number('other[start_after_days_number]',__('Start after days number'),setting('other','start_after_days_number') ?? 0) !!}
    {!! field()->date('other[subscription_start_date]',__("Subscription Start Date"),setting('other','subscription_start_date') ?? null) !!}


  </div>
</div>
