@php
$socials= [
'facebook'=>"fab fa-facebook-f",
'twitter'=>"fab fa-twitter",
'instagram'=>"fab fa-instagram",
'youtube'=>"fab fa-youtube"
];
@endphp

{{-- <footer>
  <div class="bg-shape">
    <img src="{{asset('frontend')}}/images/shapes/left-shape.png" data-parallax='{"x": -130}' alt="shape" class="shape-left">
    <img src="{{asset('frontend')}}/images/shapes/right_shape.png" data-parallax='{"x": 130}' alt="shape" class="shape-right">
  </div>
  <div class="container">
    <div class="footer-top">
      <div class="app-download">
        <div class="app-desc wow fadeInUp">
          <h2>{{ __('quick access') }}</h2>
          <div class=" d-flex justify-content-center flex-wrap">
            <ul>
              @if($aboutUs)
              <li>
                <a class="d-flex align-items-center contact-phone" href="{{ $aboutUs ? route('frontend.pages.show', $aboutUs->slug) : '#' }}">
                  {{ $aboutUs->title }}
                </a>
              </li>
              @endif
              @if($privacyPolicy)
              <li>
                <a class="d-flex align-items-center contact-phone" href="{{ $privacyPolicy ? route('frontend.pages.show', $privacyPolicy->slug) : '#' }}">
                  {{ $privacyPolicy->title }}
                </a>
              </li>
              @endif
              @if($terms)
              <li>
                <a class="d-flex align-items-center contact-phone" href="{{ $terms ? route('frontend.pages.show', $terms->slug) : '#' }}">
                  {{ $terms->title}}
                </a>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-help">
        <div class="wow fadeInUp">
          <a class="d-flex align-items-center contact-phone" href="tel:{{ setting('contact_us','call_number') }}"><img class="icon-img img-fluid"
              src="{{asset('frontend')}}/images/icons/phone-call.svg" alt="icon" /> {{ setting('contact_us','call_number') }}</a>
        </div>
        <div class="footer-contact wow fadeInUp">
          <h4>{{ __('Follow Us') }}</h4>


          <div class="footer-social">
            @foreach($socials as $key => $social)
            @if(setting('social',$key) && setting('social',$key) != '#')
            <a href="{{setting('social',$key)}}" class="social-icon"><i class="{{ $social }}"></i></a>
            @endif
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <a href="https://wa.me/{{ setting('contact_us','whatsapp') }}?text=How can we help?" target="_blank" class="whatsappbtn">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_vfaddvqs.json" background="transparent" speed="1" loop autoplay></lottie-player>
  </a>
</footer> --}}
<p class="copyrights mb-0 wow fadeIn" style="visibility: visible; animation-name: fadeIn;"><span class="ar-text">© {{trans('apps::frontend.footer_p1')}}
    <a href="https://www.tocaan.com/" target="_blank">{{trans('apps::frontend.footer_p2')}}</a>
  </span>
</p>

<div class="space"></div>
<div class="menu-modal side-modal">
  <div class="side-modal-head">
    @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
    @if ($localeCode != locale())
    <a hreflang="{{ $localeCode }}" class="header-lang" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"> {{ $properties['native']
      }}</a>
    @endif
    @endforeach
    <a class="logo" href="{{route('frontend.home')  }}"><img class="img-fluid" src="{{asset('frontend')}}/images/logo.png" alt="" /></a>
    <button class="btn close-modal"><i class="ti-close"></i></button>
  </div>
  <div class="side-modal-content">
    <div class="help-sec">
      <div class="d-flex align-items-center justify-content-between">
        @if(setting('contact_us','call_number'))
        <a href="tel:{{ setting('contact_us','call_number') }}">
          <img class="img-fluid" src="{{asset('frontend')}}/images/icons/phone.svg" alt="" />
          {{ __('Call Us') }}
        </a>
        @endif
        <a href="https://wa.me/{{ setting('contact_us','whatsapp') }}?text=How can we help?">
          <img class="img-fluid" src="{{asset('frontend')}}/images/icons/whatsapp.svg" alt="" />
          {{ __('Whatsapp') }}
        </a>
        <a href="mailto:{{ setting('contact_us','email') }}">
          <img class="img-fluid" src="{{asset('frontend')}}/images/icons/email-2.svg" alt="" />
          {{ __('Email') }}
        </a>
      </div>
      <div class="menu-social d-flex align-items-center justify-content-center">
        @foreach($socials as $key => $social)
        @if(setting('social',$key) && setting('social',$key) != '#')
        <a href="{{setting('social',$key)}}" class="social-icon"><i class="{{ $social }}"></i></a>
        @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
<div class="search-modal">
  <div class="search-form container">
    <div class="side-modal-head">
      <button class="btn close-modal"><i class="ti-close"></i> {{ __('Close') }}</button>
    </div>
    <form action="{{ route('frontend.packages.index') }}">
      <div class="form-group">
        <input type="text" id="tags" name="s" placeholder="{{ __('Search for Pacakges') }}" />
        <button class='btn' type="submit"><i class="ti-search"></i></button>
      </div>
      <div class="eventInsForm"></div>
    </form>
  </div>
</div>
<!-- Start JS FILES -->
