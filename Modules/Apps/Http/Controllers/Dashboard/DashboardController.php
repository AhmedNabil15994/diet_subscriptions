<?php

namespace Modules\Apps\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Authorization\Entities\Role;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data['usersCount'] = $this->getCountUsers($request);
        $data['SubscriptionsCount'] = $this->getCountUsers($request);
        return view('apps::dashboard.index', $data);
    }

    private function getCountUsers($request)
    {
        return $this->filter($request, (new User()))->count();
    }






    private function filter($request, $model)
    {

        return $model->where(function ($query) use ($request) {

            // Search Users by Created Dates
            if ($request->from)
                $query->whereDate('created_at', '>=', $request->from);

            if ($request->to)
                $query->whereDate('created_at', '<=', $request->to);
        });
    }
}
