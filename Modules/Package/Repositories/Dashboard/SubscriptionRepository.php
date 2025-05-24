<?php

namespace Modules\Package\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Package\Entities\Subscription;

class SubscriptionRepository extends CrudRepository
{

    public function __construct($model = null)
    {
        $this->model = new Subscription();
    }

    public function appendSearch(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        $query->orWhere(function ($query) use ($request) {
            $query->whereHas('user',function($query) use ($request) {

                $query->where('name', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
            });
        });
        return $query;
    }

    public function appendFilter(&$query, $request): \Illuminate\Database\Eloquent\Builder
    {
        // dd($request['req']);
        if (isset($request['req']['package_id']) ) {
            $query->where('package_id', $request['req']['package_id']);
        }

        if(isset($request['client_id']) && !empty($request['client_id'])){
            $query->where('user_id',$request['client_id']);
        }

        return $query->where('paid','paid')
            ->when(
                data_get($request, 'req.is_default') == 'on',
                fn ($q) => $q->where('is_default', 1)
            )
            ->when(
                data_get($request, 'req.can_order_in'),

                function ($q, $val) {
                    return  $q->whereDoesntHave('suspensions', function ($q) use ($val) {
                        return $q->where(function ($q) use ($val) {
                            return $q->where('suspensions.start_at', "<=", $val)
                                ->where('suspensions.end_at', ">=", $val);
                        });
                    });
                }
            );
    }

    public function monthlyOrders()
    {
        $data["orders_dates"] = $this->getModel()
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at,'%Y-%m')"))
            ->pluck('date');

        $ordersIncome = $this->getModel()

            ->select(DB::raw("sum(price) as profit"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->get();

        $data["profits"] = json_encode(array_pluck($ordersIncome, 'profit'));

        return $data;
    }



    public function getOrdersQuery()
    {

        return $this->getModel()
            ->where(function ($query) {
                if (request()->get('from')) {
                    $query->whereDate('created_at', '>=', request()->get('from'));
                }

                if (request()->get('to')) {
                    $query->whereDate('created_at', '<=', request()->get('to'));
                }
            });
    }

    public function allOrders()
    {
        $orders = $this->getOrdersQuery();
        return $orders->where(function ($whereQuery){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ]);
        })->count();
    }

    public function completeOrders()
    {
        $orders = $this->getOrdersQuery();
        $dates = request()->has('from') && request()->has('to') ?
            [request()->get('from'),request()->get('to')] :
            [date('Y-m-d',strtotime('-5years',strtotime('now'))),date('Y-m-d')];

        return $orders->where(function ($whereQuery) use ($dates){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ])->where([
                ['end_at','>=',$dates[0] . ' 00:00:00'],
                ['end_at','<=',$dates[1] . ' 23:59:59'],
            ]);
        })->count();
    }

    public function orderSum(){
        $orders = $this->getOrdersQuery();
        return  $orders->where('from_admin',0)->where(function ($whereQuery){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ]);
        })->get()->sum('price_after_vat');
    }

    public function totalTodayProfit()
    {
        $orders = $this->getOrdersQuery();
        return $orders->where('from_admin',0)->where(function ($whereQuery){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ])->whereDate("created_at", \DB::raw('CURDATE()'));
        })->get()->sum('price_after_vat');
    }

    public function totalMonthProfit()
    {
        $orders = $this->getOrdersQuery();
        return $orders->where('from_admin',0)->where(function ($whereQuery){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ])->whereMonth("created_at", date("m"))
                ->whereYear("created_at", date("Y"));
        })->get()->sum('price_after_vat');
    }

    public function totalYearProfit()
    {
        $orders = $this->getOrdersQuery();
        return $orders->where('from_admin',0)->where(function ($whereQuery){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ])->whereYear("created_at", date("Y"));
        })->get()->sum('price_after_vat');
    }

    public function totalProfit()
    {
        $orders = $this->getOrdersQuery();
        return $orders->where('from_admin',0)->where(function ($whereQuery){
            $whereQuery->where('is_free',1)->orWhere([
                ['is_free',0],
                ['paid','paid']
            ]);
        })->get()->sum('price_after_vat');
    }

}
