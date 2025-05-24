<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') - {{ setting('app_name',locale()) }} </title>
  <meta name="description" content="">
  <meta name="author" content="" />
  <link rel="icon" href="{{asset('frontend')}}/images/logo-2.png">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/fontawesome.min.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/animate.min.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/owl.carousel.min.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/select2.min.css" type="text/css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap-select.min.css" type="text/css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/jquery.mCustomScrollbar.css" type="text/css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/smoothproducts.css" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css" type="text/css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/style-{{ locale() }}.css">
  <link rel="stylesheet" href="{{asset('frontend')}}/css/custom-{{ locale() }}.css">
  <link rel="stylesheet" href="{{ asset('frontend/css/intlTelInput.css') }}" />
  @stack('css')
  <style>
    .dropdown-account .dropdown-toggle{
      background: transparent;
      outline: 0;
      border: 0;
    }
    html[lang="ar"] .dropdown-account{
      margin-left: 25px;
    }
    html[lang="en"] .dropdown-account{
      margin-right: 25px;
    }
    .float-left{
      float:left;
    }
    .float-right{
      float:right;
    }
    .remove-flex{
      display: block;
      width: 100%;
    }
    .hidden{
      display: none !important;
    }
    .w-100{
      width: 100% !important;
    }
    .right-side .dropdown-account .dropdown-toggle::after{
      display: none;
    }
    @media(max-width: 767px){
      .right-side .dropdown-account{
        margin:0 !important;
        margin-top: 10px !important;
      }
      .header-lang{
        padding-top: 10px;
      }
    }
  </style>
</head>
