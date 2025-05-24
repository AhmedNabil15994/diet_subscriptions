<?php

namespace Modules\Area\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Repositories\FrontEnd\AreaRepository as Area;
use Modules\Area\Transformers\FrontEnd\AreaSelectorResource;

class AreaController extends Controller
{

    public function getChildAreaByParent(Request $request)
    {
        return AreaSelectorResource::collection((new Area)->getChildAreaByParent($request))->jsonSerialize();
    }
}
