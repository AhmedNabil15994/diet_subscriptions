
@inject('packages','Modules\Package\Entities\Package')
@inject('countries','Modules\Area\Entities\Country')
@push('styles')
  <style>
    .hidden{
      display: none;
    }
  </style>
@endpush

{!!
  field()->select('package',
    __('Package'),
    $packages->pluck('title','id')->toArray(), null
) !!}


<div class="form-group row" style="display: none" id="loader">
  <label class="col-sm-3 col-form-label"></label>
  <div class="col-sm-9">
      <div class=" spinner-border text-warning" role="status">
          <span class="sr-only">Loading...</span>
      </div>
  </div>
</div>

<div id="prices">
</div>
{!! field()->date('start_date',__('subscribtion Date'),(isset($model) && isset($model->start_at) ? $model->start_at : Carbon\Carbon::now()->addDay()->toDateString()) ) !!}
{!! field()->date('end_at',__('Subscribtion End Date'),(isset($model) && isset($model->end_at) ? $model->end_at : null)) !!}

<div class="portlet-title">
  <div class="caption font-red-sunglo">
      <i class="icon-settings font-red-sunglo"></i>
      <span class="caption-subject bold uppercase">{{__('Address')}}</span>
  </div>
</div>
<hr>
{!!
  field()->select(
      'country_id',
    '',
    $countries->active()->pluck('title','id')->toArray(),1,['class'=>'hidden'],
) !!}

<div id="cities">
</div>
{!! field()->text('street',__('Streat') , isset($model) && isset($model->Address) ? $model->Address->street : '') !!}
{!! field()->text('block',__('Block No.'), isset($model) && isset($model->Address) ? $model->Address->block : '') !!}
{!! field()->text('gada',__('Gada Address'), isset($model) && isset($model->Address) ? $model->Address->gada : '') !!}
{!! field()->text('building',__('Building No., Floor, Flat No.'), isset($model) && isset($model->Address) ? $model->Address->building : '') !!}
{!! field()->textarea('note',__('Note'),null,['class' => 'form-control'], isset($model) ? $model->notes : '') !!}

@push('scripts')
  <script src="https://momentjs.com/downloads/moment.js"></script>
<script>
  $('#package').on('change', function() {

    var url = '{{ route("dashboard.packages.get-prices", ":id") }}';
    url = url.replace(':id', this.value);

    $.ajax({
      url: url,
      type: 'GET',

      beforeSend: function () {
          $('#prices').text('');
          $('#loader').show();
      },
      success: function (data) {

          $('#loader').hide();
          $('#prices').text('').append(data.html);
          @if(isset($model) && isset($model->Address))
          $('#price_id').val({{$model->package_price_id}}).trigger('change')
          @endif
          $('.select2').select2();

      },
      error: function (data) {
          $('#loader').hide();
      }
    });
  });
  $('#country_id').on('change', function() {

    var url = '{{route('dashboard.area.get_child_area_by_parent')}}?country_id='+this.value;

    $.ajax({
      url: url,
      type: 'GET',

      beforeSend: function () {
          $('#cities').text('');
          $('#loader').show();
      },
      success: function (data) {

          $('#loader').hide();
          $('#cities').text('').append(data.html);
          @if(isset($model) && isset($model->Address))
          $('#state_id').val({{$model->Address->state_id}}).trigger('change')
          @endif
          $('.select2').select2();
      },
      error: function (data) {
          $('#loader').hide();
      }
    });
  });
  
  @if(isset($model) && isset($model->Address))
    let firstChange = true;
    $('#package').val({{$model->package_id}}).trigger('change')
  @else
    let firstChange = false;
  @endif
  let create = '{{isset($model) && isset($model->Address) ? 0 : 1}}';
  $('#country_id').val(1).trigger('change')

  $(document).on('change','#price_id',function (){
    let subscribe_start_at = $(this).children('option:selected').data('area');
    if(!subscribe_start_at){
      subscribe_start_at = moment().add(1,'days').format("YYYY-MM-DD");
    }

    if(firstChange){
      firstChange = false;
    }else{

      $('#start_date').attr('min',subscribe_start_at)
      $('#start_date').attr('value',subscribe_start_at)
    }

    updateEndAt()
  });

  function updateEndAt(){
    let url = "{{route('dashboard.packages.get-end-at',['::priceId','::startAt'])}}";
    url = url.replace('::priceId', $("#price_id").val());
    url = url.replace('::startAt', $("#start_date").val());

    $.ajax({
      url: url,
      type: 'GET',

      success: function (data) {

        $('#end_at').val(data.end_at);
      },
    });
  }

  
  $('#start_date').change(function() {
    updateEndAt()
  });
</script>
@endpush
