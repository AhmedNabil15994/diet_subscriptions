{!! field()->langNavTabs() !!}
<div class="tab-content">
  @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
  <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
    id="first_{{$code}}">
    {!! field()->text('title['.$code.']',
    __('sliders::dashboard.sliders.form.title').'-'.$code ,
    $model->getTranslation('title',$code),
    ['data-name' => 'title.'.$code]
    ) !!}
  </div>
  @endforeach
</div>


{!! field()->text('link', __('sliders::dashboard.sliders.form.link')) !!}
{!! field()->number('order', __('sliders::dashboard.sliders.form.order')) !!}
{!! field()->file('image', __('sliders::dashboard.sliders.form.image'), $model->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('status', __('sliders::dashboard.sliders.form.status')) !!}
@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('sliders::dashboard.sliders.form.restore')) !!}
@endif
