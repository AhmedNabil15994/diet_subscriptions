<?php

namespace Modules\Area\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Repositories\FrontEnd\AreaRepository as Area;
use Modules\Area\Transformers\FrontEnd\AreaSelectorResource;
use Modules\Core\Traits\Dashboard\CrudDashboardController;

class AreaController extends Controller
{
    use CrudDashboardController;


    public function getChildAreaByParent(Request $request)
    {
        $cities = AreaSelectorResource::collection((new Area)->getChildAreaByParent($request))->jsonSerialize();
        
        return response()->json(['html' => 
        view('package::dashboard.subscriptions.components.state-selector',compact('cities'))->render()]);
    }
}
