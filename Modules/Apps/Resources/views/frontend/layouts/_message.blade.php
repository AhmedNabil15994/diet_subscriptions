@if($errors->all())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@if(session('msg'))
<div class="alert alert-{{session('alert')}}"
  align="center">
  
  <h4>{{session('msg')}}</h4>
</div>
@endif