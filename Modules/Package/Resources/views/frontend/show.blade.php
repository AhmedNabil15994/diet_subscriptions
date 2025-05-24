@extends('apps::frontend.layouts.app')
@section( 'title',$package->title)
@section( 'content')
<div class="inner-page">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="sp-wrap">
          <img src="{{ $package->getFirstMediaUrl('images') }}"
            class="img-responsive"
            alt="img">
        </div>
      </div>
      <div class="col-md-6">
        <div class="content">
          <div class="pro-head d-flex justify-content-between align-items-center w-100">
            <div class="w-100">
              <h1 class="pro-name">{{ $package->title }}</h1>
              @if($package->is_free)
              <div class="price mb-3 ">{{ __('free package') }}</div>
              @else
                <div class="form-group mb-3 " style="margin-bottom: 0px">
                  <select onchange="changeItemData(this,true)" style="height:36px;line-height: 26px;padding: 0rem 1rem;" class="select2_package form-control">

                    <option value="">select Duration</option>
                    @foreach($package->prices as $priceItem)
                      <option {{$loop->first ? 'selected' : ''}} value="{{$package->id}}" data-item="{{$priceItem}}" data-area="{{setting('other','subscription_start_date')}}">{{$priceItem->subscribe_duration_desc}}</option>
                    @endforeach
                  </select>
                </div>

                @php
                  $firstPrice = $package->prices()->first();
                  $addDays = setting('other','start_after_days_number') && setting('other','start_after_days_number') > 0 ? setting('other','start_after_days_number') : 1;
                  $minDate = setting('other','subscription_start_date') ? Carbon\Carbon::parse(setting('other','subscription_start_date'))->addDays($addDays)->toDateString() : Carbon\Carbon::now()->addDays($addDays)->toDateString();
                  @endphp
                <div class="form-group">
                  <label for="">{{__('start')}}</label>
                  <input type="text" class="form-control" name="start" value="{{date(( is_rtl() == 'rtl' ? 'd/m/Y' : 'm/d/Y'),strtotime($minDate))}}" placeholder="{{__('start')}}">
                </div>

                @php $packagePrice = $package->prices()->first(); @endphp
                <div class="price_data" style="display:{{$packagePrice ? 'block':'none'}};margin-top: 21px;">
                  <div class="block">
                    <h4 class="inner-title">{{__('Duration')}}: {{optional($packagePrice)->subscribe_duration_desc}}</h4>
                  </div>
                  <div class="the_price">{!! $packagePrice ? $packagePrice->active_price['price_html'] : '' !!}</div>
                </div>
              @endif
            </div>
          </div>
          @if($package->description)
          <p class="pro-desc">
            {!! $package->description !!}
          </p>
          @endif
          <div class="share-pro d-flex align-items-center">
            <h4 class='mb-0'>{{ __('Share') }}: </h4>
            <div class="share-btns">
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('frontend.packages.show',$package->id) }}"
                target="_blank"><i class="fab fa-facebook-f"></i>
              </a>
              <a href="http://twitter.com/share?text={{ $package->title }}&url={{ route('frontend.packages.show',$package->id) }}"
                target="_blank"><i class="fab fa-twitter"></i></a>
              <a href="http://pinterest.com/pin/create/button/?url={{ route('frontend.packages.show',$package->id) }}"
                target="_blank">
                <i class="fab fa-pinterest-p"></i>
              </a>
              <a href="https://wa.me?text={{ route('frontend.packages.show',$package->id) }}"
                target="_blank">
                <i class="fab fa-whatsapp"></i>
              </a>
            </div>
          </div>

          @if(canOrderStatus())
          <div>
            <a class="btn addto-cart theme-btn my-3" id="addto-cart" style="display:{{$package->is_free || $packagePrice ? 'block' : 'none'}}"
              href="{{ $package->is_free ? route('frontend.packages.subscribeForm',$package->id) : ($packagePrice ? route('frontend.packages.subscribeForm',$packagePrice->id).'?start='.$minDate : '#') }}">
              {{ __('Subscribe now') }}</a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

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
      $('input[name="start"]').datepicker({
        mode:'inline',
        startDate: new Date("{{$minDate}}"),
        minDate: new Date("{{$minDate}}"),
      });
      $('input[name="start"]').on('change',function(){
        $('#addto-cart').attr('href', "{{canOrderStatus() ? (route('frontend.packages.subscribeForm',$packagePrice->id)) : '#'}}"+'?start='+ moment($(this).val(),"{{is_rtl() == 'rtl' ? 'DD/MM/YYYY' : 'MM/DD/YYYY'}}").format("YYYY-MM-DD"))
      });
    });
  </script>
@endpush
