<?php

namespace Modules\Apps\Http\Controllers\Frontend;

use Illuminate\Routing\Controller;
use Modules\Sliders\Entities\Slider;
use Modules\Category\Entities\Category;
use Modules\Package\Repositories\Frontend\PackageRepository;

class HomeController extends Controller
{
    public function __invoke()
    {
        $data['sliders'] = Slider::latest('order')->active()->get();
        $data['packages'] = (new PackageRepository)->getAllActive();
        return view('apps::frontend.index', $data);
    }
}
