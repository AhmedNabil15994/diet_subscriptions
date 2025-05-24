<?php

namespace Modules\Setting\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Repositories\Dashboard\SettingRepository as Setting;
use Modules\Core\Traits\Dashboard\ControllerResponse;

class SettingController extends Controller
{

    function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting::dashboard.index');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     */
    public function update(Request $request)
    {
        $request['vacation'] = $request['vacation'] ?? null;

        $this->setting->set($request);

        return Response()->json([true, __('apps::dashboard.messages.updated')]);
    }
}
