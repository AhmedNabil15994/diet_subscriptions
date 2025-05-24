<?php

namespace Modules\Sliders\Repositories\Api;

use Modules\Sliders\Entities\Slider;

class SliderRepository
{
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function getAll($request)
    {
        $sliders = $this->slider->Active()->Published()->orderBy('order')->get();

        return $sliders;
    }
}
