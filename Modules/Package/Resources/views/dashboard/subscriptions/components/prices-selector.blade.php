<div class="form-group " id="price_id_wrap">

  <label for="price_id" class="col-md-2" style="">
    {{__('Prices')}}
  </label>

  <div class="col-md-9" style="">

    <select class="form-control select2" data-name="price_id" id="price_id" name="price_id">
      <option selected="selected" value="">{{__('Prices')}}</option>
      @foreach($prices as $key => $price)
        <option value="{{$price->id}}" data-area="{{setting('other','subscription_start_date')}}" data-days="{{$price->days_count}}">{{$price->subscribe_duration_desc}}</option>
      @endforeach
    </select>

    <span class="help-block" style=""></span>

  </div>

</div>
