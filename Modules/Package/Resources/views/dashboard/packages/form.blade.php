{!! field()->langNavTabs() !!}

<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ $code == locale() ? 'active' : '' }}"
    id="first_{{ $code }}">
    {!! field()->text(
    'title[' . $code . ']',
    __('package::dashboard.packages.form.title') . '-' . $code,
    $model->getTranslation('title', $code),
    ['data-name' => 'title.' . $code],
    ) !!}
    {!! field()->ckEditor5(
    'description[' . $code . ']',
    __('package::dashboard.packages.form.description') . '-' . $code,
    $model->getTranslation('description', $code),
    ['data-name' => 'description.' . $code],
    ) !!}
  </div>
  @endforeach
</div>

{!!
field()->select('categories[]',__('package::dashboard.packages.form.categories'),$extraData['categories'],$model->categories??[],['multiple'=>'multiple','data-name'=>'categories']
) !!}

{!! field()->file('image', __('package::dashboard.packages.form.image'),$model->getFirstMediaUrl('images')) !!}

{!! field()->checkBox('status', __('package::dashboard.packages.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('apps::dashboard.datatable.form.restore')) !!}
@endif



@push('scripts')
<script>
  $('#is_free').bootstrapSwitch({
        onInit:function (e, state){
          if($(this).is(':checked')){
                $('.prices').hide()
          }
        },
        onSwitchChange: function (e, state) {
              $('.prices').toggle()
        }
      });
</script>
@endpush
