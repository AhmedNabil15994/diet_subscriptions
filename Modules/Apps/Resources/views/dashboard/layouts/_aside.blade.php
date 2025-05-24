<div class="page-sidebar-wrapper">

  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed"
      data-keep-expanded="false"
      data-auto-scroll="true"
      data-slide-speed="200"
      style="padding-top: 20px">

      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>
      <li class="nav-item {{ active_menu('home') }}">
        <a href="{{ url(route('dashboard.home')) }}"
          class="nav-link nav-toggle">
          <i class="icon-home"></i>
          <span class="title">{{ __('apps::dashboard.index.title') }}</span>
          <span class="selected"></span>
        </a>
      </li>

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
      </li>

      @canany(['show_categories','show_packages'])
        <li class="nav-item  {{active_slide_menu(['packages','categories',])}}">
          <a href="javascript:;"
             class="nav-link nav-toggle">
            <i class="icon-docs"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.packages') }}</span>
            <span class="arrow {{active_slide_menu(['packages','categories',])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu">
            @can('show_packages')
              <li class="nav-item {{ active_menu('packages') }}">
                <a href="{{ url(route('dashboard.packages.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.packages') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('show_categories')
              <li class="nav-item {{ active_menu('categories') }}">
                <a href="{{ url(route('dashboard.categories.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-layers"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.categories') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcanAny


      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.subscriptions') }}</h3>
      </li>

      @canany(['show_subscriptions','show_suspensions','edit_coupons',])
        <li class="nav-item  {{active_slide_menu(['subscriptions','suspensions','coupons'])}}">
          <a href="javascript:;"
             class="nav-link nav-toggle">
            <i class="icon-docs"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.subscriptions') }}</span>
            <span class="arrow {{active_slide_menu(['subscriptions','suspensions','coupons'])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu">
            @can('show_subscriptions')
              <li class="nav-item {{ active('dashboard.subscriptions.index') }}">
                <a href="{{ url(route('dashboard.subscriptions.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.subscriptions') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('show_subscriptions')
              <li class="nav-item {{ active('dashboard.subscriptions.today_orders') }}">
                <a href="{{ route('dashboard.subscriptions.today_orders') }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside._tabs.subscription_orders') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
              <li class="nav-item {{ active('dashboard.subscriptions.after_omorrow_orders') }}">
                <a href="{{ route('dashboard.subscriptions.after_tomorrow_orders') }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.after_omorrow_orders') }}</span>
                  <span class="selected"></span>
                </a>
              </li>

            @endcan
            @can('show_suspensions')
              <li class="nav-item {{ active_menu('suspensions') }}">
                <a href="{{ url(route('dashboard.suspensions.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.suspensions') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('edit_coupons')
              <li class="nav-item {{ active_menu('coupons') }}">
                <a href="{{ url(route('dashboard.coupons.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.coupons') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcanAny

      @canany(['show_transactions'])
        <li class="nav-item  {{active_slide_menu(['transactions',])}}">
          <a href="javascript:;"
             class="nav-link nav-toggle">
            <i class="icon-docs"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.transactions') }}</span>
            <span class="arrow {{active_slide_menu(['transactions',])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu">
            @can('show_transactions')
              <li class="nav-item {{ active_menu('transactions') }}">
                <a href="{{ url(route('dashboard.transactions.paid')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.paid_transactions') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('show_transactions')
              <li class="nav-item {{ active_menu('transactions') }}">
                <a href="{{ url(route('dashboard.transactions.pending')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-layers"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.pending_transactions') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcanAny

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.other') }}</h3>
      </li>

      @canany(['show_roles','show_admins','show_users',])
        <li class="nav-item  {{active_slide_menu(['roles','admins','users',])}}">
          <a href="javascript:;"
             class="nav-link nav-toggle">
            <i class="icon-users"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
            <span class="arrow {{active_slide_menu(['roles','admins','users',])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu">
            @can('show_admins')
              <li class="nav-item {{ active_menu('admins') }}">
                <a href="{{ url(route('dashboard.admins.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-users"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('show_users')
              <li class="nav-item {{ active_menu('users') }}">
                <a href="{{ url(route('dashboard.users.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-users"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
            @can('show_roles')
              <li class="nav-item {{ active_menu('roles') }}">
                <a href="{{ url(route('dashboard.roles.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="icon-briefcase"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcanAny

      @canany(['show_subscriptions'])
        <li class="nav-item  {{active_slide_menu(['print-settings','print'])}}">
          <a href="javascript:;"
             class="nav-link nav-toggle">
            <i class="icon-printer"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.print-settings') }}</span>
            <span class="arrow {{active_slide_menu(['print-settings','print',])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu">
            @can('show_subscriptions')
              <li class="nav-item {{ active('dashboard.print-settings.index') }}">
                <a href="{{ route('dashboard.print-settings.index') }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.print-settings') }}</span>
                  <span class="selected"></span>
                </a>
              </li>

              <li class="nav-item {{ active('dashboard.print.index') }}">
                <a href="{{ route('dashboard.print.index') }}"
                   class="nav-link nav-toggle">
                  <i class="icon-docs"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.print') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcanAny

      @can('edit_settings')
      <li class="nav-item {{ active_menu('setting') }}">
        <a href="{{ url(route('dashboard.setting.index')) }}"
          class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @canany(['show_countries','show_areas','show_cities','show_states'])
        <li class="nav-item  {{active_slide_menu(['countries','cities','states','areas'])}}">
          <a href="javascript:;"
             class="nav-link nav-toggle">
            <i class="icon-pointer"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
            <span class="arrow {{active_slide_menu(['countries','governorates','cities','regions'])}}"></span>
            <span class="selected"></span>
          </a>
          <ul class="sub-menu">

            @can('show_countries')
              <li class="nav-item {{ active_menu('countries') }}">
                <a href="{{ url(route('dashboard.countries.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="fa fa-building"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan

            @can('show_cities')
              <li class="nav-item {{ active_menu('cities') }}">
                <a href="{{ url(route('dashboard.cities.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="fa fa-building"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan

            @can('show_states')
              <li class="nav-item {{ active_menu('states') }}">
                <a href="{{ url(route('dashboard.states.index')) }}"
                   class="nav-link nav-toggle">
                  <i class="fa fa-building"></i>
                  <span class="title">{{ __('apps::dashboard._layout.aside.state') }}</span>
                  <span class="selected"></span>
                </a>
              </li>
            @endcan
          </ul>
        </li>
      @endcanAny

      @can('show_sliders')
        <li class="nav-item {{ active_menu('sliders') }}">
          <a href="{{ url(route('dashboard.sliders.index')) }}"
             class="nav-link nav-toggle">
            <i class="icon-docs"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.sliders') }}</span>
            <span class="selected"></span>
          </a>
        </li>
      @endcan

      @can('show_pages')
        <li class="nav-item {{ active_menu('pages') }}">
          <a href="{{ url(route('dashboard.pages.index')) }}"
             class="nav-link nav-toggle">
            <i class="icon-docs"></i>
            <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
            <span class="selected"></span>
          </a>
        </li>
      @endcan

      @can('show_logs')
      <li class="nav-item {{ active_menu('logs') }}">
        <a href="{{ url(route('dashboard.logs.index')) }}"
          class="nav-link nav-toggle">
          <i class="icon-folder"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.logs') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_logs')
      <li class="nav-item {{ active_menu('devices') }}">
        <a href="{{ url(route('dashboard.devices.index')) }}"
          class="nav-link nav-toggle">
          <i class="fa fa-mobile"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.devices') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_telescope')
      <li class="nav-item {{ active_menu('telescope') }}">
        <a href="{{ url(route('telescope')) }}"
          class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.telescope') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
    </ul>
  </div>

</div>
