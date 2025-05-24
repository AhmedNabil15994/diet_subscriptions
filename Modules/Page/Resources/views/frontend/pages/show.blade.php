@extends('apps::frontend.layouts.app')
@section( 'title',$page->title)
@section( 'content')
<div class="section-block">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="mb-3 mt-3" style="margin: auto">{{$page->title }}</h2>
    </div>
    <div>
      {!! $page->description !!}
    </div>
  </div>
</div>
@endsection
