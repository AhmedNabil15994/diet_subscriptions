@extends('apps::frontend.layouts.app')
@section( 'title',__('home'))
@section( 'content')
<div class="home-slider owl-carousel">
  @foreach($sliders as $key => $slider)
  <a class="d-block slide" href="{{ $slider->link }}">
    <img class="img-fluid" src="{{ $slider->getFirstMediaUrl('images') }}" alt="" />
  </a>
  @endforeach
</div>
<div class="section-block">
  <div class="container">
    <div class="section-title d-flex justify-content-between align-items-center">
      <h2 class="mb-0">{{ __('Browse categories') }}</h2>
    </div>
    <div class="row">
      @foreach($categories as $key => $category)
      <div class="col-md-3 col-6">
        <a class="category-block" href="{{ route('frontend.packages.index',['category_id'=>$category->id]) }}">
          <div class="img-block">
            <img class="img-fluid" src="{{ $category->getFirstMediaUrl('images') }}" alt="" />
          </div>
          <h3>{{ $category->title }}</h3>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</div>
{{--<div class="section-block">--}}
{{--  <div class="container">--}}
{{--    <div class="section-title d-flex justify-content-between align-items-center">--}}
{{--      <h2 class="mb-0">{{ __('New Packages') }}</h2>--}}
{{--      <a class="seemore-link" href="{{ route('frontend.packages.index') }}"><span>{{ __('See more') }}</span></a>--}}
{{--    </div>--}}
{{--    <div class="home-products owl-carousel">--}}
{{--      @foreach($packages as $key => $package)--}}
{{--      <div class="item">--}}
{{--        @include('package::frontend.partials.item')--}}
{{--      </div>--}}
{{--      @endforeach--}}
{{--    </div>--}}
{{--  </div>--}}
{{--</div>--}}

@endsection
