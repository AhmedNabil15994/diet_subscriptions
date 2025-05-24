<?php

namespace Modules\Sliders\ViewComposers\Frontend;

use Modules\Sliders\Repositories\Frontend\SliderRepository as Slider;
use Illuminate\View\View;
use Cache;

class SliderComposer
{
    public function __construct(Slider $slider)
    {
        $this->sliders =  $slider->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sliders', $this->sliders);
    }
}
