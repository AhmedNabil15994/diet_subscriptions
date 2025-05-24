<!DOCTYPE html>
<html lang="{{ locale() }}">
@include('apps::frontend.layouts.head')
@include('apps::frontend.layouts.header')
<main>
  @include('apps::frontend.layouts._message')
  @yield('content')
</main>
@include('apps::frontend.layouts.footer')
@include('apps::frontend.layouts._js')
</body>
</html>
