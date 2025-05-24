<div class="form-group " id="state_wrap">
        
    <label for="state_id" class="col-md-2" style="">
      @lang('select state')
            </label>
  
    <div class="col-md-9" style="">
  
        <select id="state_id"  name="state_id"  class="form-control" style="padding: 0.2rem 1rem;">
          <option value="">{{__('select state')}}..</option>
          @foreach ($cities as $city)
            <optgroup label="{{$city['title']}}" data-select2-id="{{$city['id']}}">
              @foreach ($city['states'] as $state)
                <option value="{{$state['id']}}" data-select2-id="{{$state['id']}}">{{$state['title']}}</option>
              @endforeach
            </optgroup>
          @endforeach
            
        </select>
  
      <span class="help-block" style=""></span>
  
    </div>
  
  </div>