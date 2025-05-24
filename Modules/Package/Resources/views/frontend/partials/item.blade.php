<div class="product-block">
  <a href="{{ route('frontend.packages.show',$package->id) }}" class="img-block">
    <img class="img-fluid" src="{{$package->getFirstMediaUrl('images')}}" alt="" />
  </a>
  <div class="content-block">
    <a class="pro-name" href="{{ route('frontend.packages.show',$package->id) }}">{{ $package->title }}</a>
    @php
      $firstPrice = $package->prices()->first();
      $addDays = setting('other','start_after_days_number') && setting('other','start_after_days_number') > 0 ? ((int)setting('other','start_after_days_number')) : 1;

      $minDate = setting('other','subscription_start_date') ? Carbon\Carbon::parse(setting('other','subscription_start_date'))->addDays($addDays)->toDateString() : Carbon\Carbon::now()->addDays($addDays)->toDateString();
    @endphp
    <div class="form-group">
      <label for="">{{__('start')}}</label>
      <input type="text" class="form-control" name="start" value="{{date(( is_rtl() == 'rtl' ? 'd/m/Y' : 'm/d/Y'),strtotime($minDate))}}" placeholder="{{__('start')}}">
    </div>
    @if($package->is_free)
      <div class="price">{{ __('free package') }}</div>

      @if(canOrderStatus())
        <a class="btn addto-cart theme-btn" href="{{ route('frontend.packages.subscribeForm',$package->id) }}">
          {{ __('Subscribe now') }}
        </a>
      @endif
    @else
      <div class="form-group" style="margin-bottom: 0px">
          <select onchange="changeItemData(this)" style="height:36px;line-height: 26px;padding: 0rem 1rem;" class="select2_package form-control">

            <option value="">{{__('select Duration')}}</option>
            @foreach($package->prices as $priceItem)
              <option {{$loop->first ? 'selected' : ''}} value="{{$package->id}}" data-area="{{setting('other','subscription_start_date')}}" data-item="{{$priceItem}}">{{$priceItem->subscribe_duration_desc}}</option>
            @endforeach
          </select>
      </div>
      @php $packagePrice = $package->prices()->first(); @endphp
      <div class="price_data" style="display:{{$packagePrice ? 'block':'none'}};margin-top: 21px;">
        <div class="block">
          <h4 class="inner-title">{{__('Duration')}}: {{optional($packagePrice)->subscribe_duration_desc}}</h4>
        </div>
        <div class="the_price">{!! $packagePrice ? $packagePrice->active_price['price_html'] : '' !!}</div>
        @if(canOrderStatus())
          <a class="btn addto-cart theme-btn" href="{{ $packagePrice ? route('frontend.packages.subscribeForm',$packagePrice->id).'?start='.$minDate : '#' }}">
            {{ __('Subscribe now') }}
          </a>
        @endif
      </div>
    @endif
  </div>
</div>
@push('css')
  <style>
    .ui-widget.ui-widget-content{
      width: auto;
      border: 1px solid #c5c5c5;
      z-index: 50 !important;
      background: #fff;
    }
    .ui-state-active, .ui-widget-content .ui-state-active{
      width: 28px;
      height: 28px;
      line-height: 1.8;
    }
  </style>
@endpush
@push('js')
  <script>
    $(function(){
      $('input[name="start"]').on('change',function(){
        $(this).parent().parent().find('.addto-cart').attr('href', "{{canOrderStatus() ? (route('frontend.packages.subscribeForm',$packagePrice->id)) : '#'}}"+'?start='+ moment($(this).val(),"{{is_rtl() == 'rtl' ? 'DD/MM/YYYY' : 'MM/DD/YYYY'}}").format("YYYY-MM-DD"))
      })

      $('input[name="start"]').datepicker({
        mode:'inline',
        
        language: 'en',
        startDate: new Date("{{$minDate}}"),
        minDate: new Date("{{$minDate}}"),
      });
    });
  </script>
@endpush
