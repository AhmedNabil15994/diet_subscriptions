<body data-bs-spy="scroll" data-bs-target="#navbar-example2">
  @if(App::environment('production'))
  <div id="preloader">
    <div id="preloader-circle">
      <span></span>
      <span></span>
    </div>
  </div>
  @endif

  <!--Start Header Area-->
  <div class="body-overlay" id="body-overlay"></div>
  <header>
    <div class="middle-header">
      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="left-side">
            <a class="header-logo" href="{{ route('frontend.home') }}"><img class="img-fluid"
                src="{{setting('logo')?asset(setting('logo')):asset('frontend/images/logo.png')}}" alt="" /></a>
          </div>
          <div class="right-side">
            <button class="search-btn header-btn"><img class="img-fluid icon-img" src="{{asset('frontend')}}/images/icons/search.svg" alt="" /> <span
                class="btn-text">{{ __('Search') }}</span></button>
            @auth
              <a href="{{ route('frontend.subscriptions.index') }}" class="header-btn">
                <img class="img-fluid icon-img" src="{{asset('frontend')}}/images/icons/user.svg" alt="" />
                <span class="btn-text">{{trans('apps::frontend.myAccount')}}</span>
              </a>
            @else
            <a class="header-btn" href="{{ route('frontend.auth.login') }}"><i class="fa-sharp fa-solid fa-right-to-bracket"></i>
              <span class="btn-text">
                {{ __('login') }}</span>
            </a>
            @endauth
            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
            @if ($localeCode != locale())
            <a hreflang="{{ $localeCode }}" class="header-lang" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"> {{
              $properties['native'] }}</a>
            @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-header">
      <div class="container">
        <button class="menu-responsive"><i class="ti-menu"></i> {{ __('Menu') }}</button>
        <div class="main-menu">
          <button class="btn close-modal"><i class="ti-close"></i> {{ __('Close') }}</button>
          <ul>
            <li>
              <a href="{{route('frontend.home')}}">{{ __('home') }}</a>
            </li>
            @foreach($categories as $key => $category)
            <li>
              <a href="{{ route('frontend.packages.index',['category_id'=>$category->id]) }}">{{ $category->title }}</a>
            </li>
            @endforeach
            <li>
              <a href="{{ route('frontend.packages.index') }}">{{ __('packages') }}</a>
            </li>
            <li>
              <a href="{{ route('frontend.contacts.index') }}"> {{ __('contact us') }} </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
