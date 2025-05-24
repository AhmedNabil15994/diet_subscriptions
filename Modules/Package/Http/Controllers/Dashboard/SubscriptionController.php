<?php

namespace Modules\Package\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use IlluminateAgnostic\Arr\Support\Carbon;
use Modules\Package\Entities\PackagePrice;
use Modules\Package\Entities\PrintSetting;
use Modules\Package\Entities\Subscription;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Illuminate\Http\Request;
use Modules\Core\Traits\DataTable;
use Illuminate\Support\Facades\App;
use Modules\Package\Entities\Suspension;
use Modules\User\Entities\User;

class SubscriptionController extends Controller
{
    use CrudDashboardController;


    public function todayOrders()
    {
        return view('package::dashboard.subscriptions.today-orders');
    }

    public function afterTomorrowOrders()
    {
        $datatableRoute = 'dashboard.subscriptions.after_tomorrow_orders.datatable';
        $can_order_in_date = Carbon::now()->addDays(2)->toDateString();
        return view('package::dashboard.subscriptions.today-orders',compact('datatableRoute','can_order_in_date'));
    }

    public function toDayDatatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repository->QueryTable($request)->Today());

        $resource = $this->model_resource;
        $datatable['data'] = $resource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function afterTomorrowDatatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repository->QueryTable($request)->AfterTomorrow());

        $resource = $this->model_resource;
        $datatable['data'] = $resource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function getSubscriptionById($id)
    {
        return response()->json(Subscription::find($id));
    }

    public function print(Request $request)
    {
        $subscriptions = Subscription::whereIn('id',$request->ids)->latest()->get();
        $print_setting_details    = PrintSetting::find($request->print_setting_id);

        if($print_setting_details->stickers_in_one_row == 1){
            $print_setting_details->col_distance = 0;
            $print_setting_details->row_distance = 0;
        }

        $margin_top = $print_setting_details->is_continuous ? 0: $print_setting_details->top_margin*1;
        $margin_left = $print_setting_details->is_continuous ? 0: $print_setting_details->left_margin*1;
        $paper_width = $print_setting_details->paper_width* 1;

        $total_qty    = count($subscriptions);
        $paper_height = $print_setting_details->paper_height  ? $print_setting_details->paper_height : $total_qty * $print_setting_details->height  ;

        $withoutPrintCon = true;

        $html     = view("package::dashboard.print.ajex.print",
                 compact(
                    "request",
                    "subscriptions",
                    "print_setting_details",
                    "margin_top",
                    "margin_left",
                    "paper_height",
                    "total_qty"
                    )
                 )->render();

        return Response()->json([true, 'print' => $html]);
    }

    public function store()
    {
        $request = App::make($this->request);

        try {
        DB::beginTransaction();
            $packagePrice = PackagePrice::findOrFail($request->price_id);
            $package = $packagePrice->package;

            if ($request->client_type == 'create') {

                $user = User::create(['mobile' => $request->user_mobile, 'name' => $request->user_name]);

            } else {

                $user = User::find($request->user_id);
            }

            $subscriptionData =
            [
                'start_at' => $request->start_date,
                'note' => $request->note,
                'paid' => $package->is_free ? 'paid' : 'pending',
                'is_default' => 1,
            ];

            if($request->end_at){
                $subscriptionData['end_at'] = $request->end_at;
            }

            $subscription =  $package->createSubscriptions($user->id,$packagePrice,null,true,$subscriptionData);
            $subscription->refresh();
            $subscription->createAddress($request);


            if ($subscription) {
                DB::commit();
                return Response()->json([true, __('apps::dashboard.messages.created')]);
            }

            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            DB::rollback();
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function update($id)
    {
        $request = App::make($this->request);

        try {

            DB::beginTransaction();
            $packagePrice = PackagePrice::findOrFail($request->price_id);
            $package = $packagePrice->package;
            $subscription = Subscription::findOrFail($id);
            if ($subscription) {
                $user = User::find($subscription->user_id);
                $subscription->delete();
                $subscription->Address->delete();
            }

            $subscriptionData =
            [
                'start_at' => $request->start_date,
                'note' => $request->note,
                'paid' => $package->is_free ? 'paid' : 'pending',
                'is_default' => 1,
            ];

            if($request->end_at){
                $subscriptionData['end_at'] = $request->end_at;
            }

            $subscription =  $package->createSubscriptions($user->id,$packagePrice,null,true,$subscriptionData);
            $subscription->id = $id;
            $subscription->save();
            $subscription->refresh();
            $subscription->createAddress($request);


            if ($subscription) {
                DB::commit();
                return Response()->json([true, __('apps::dashboard.messages.created')]);
            }

            return Response()->json([false, __('apps::dashboard.messages.failed')]);
        } catch (\PDOException $e) {
            DB::rollback();
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function permanentSuspension(Request $request , $id)
    {
        try {
            DB::beginTransaction();
            $start_at = $request->start_at ? $request->start_at : date('Y-m-d');

            $subscriptionDays = 0;
            $total = 0;
            $off = 0;
            $currentSubscription = Subscription::find($id);
            $startDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->start_at);
            $endDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->end_at);
            $pauseStart = Carbon::createFromFormat('Y-m-d', $start_at);
            $pauseEnd = $request->end_at ? $request->end_at : null;

            $supscriptionDates = getDaysArray($startDate,$endDate);
            $def = Carbon::parse($startDate)->diffInDays($endDate);

            $week_end = [];
            $vacations = [];
            if(setting('week_end')){
                $week_end = setting('week_end');
            }
            if( setting('vacation')){
                $vacations = setting('vacation')['date_range'][array_keys(setting('vacation')['date_range'])[0]];
                $vacations = explode(' - ',$vacations);
            }

            foreach ($supscriptionDates as $day){
                $day = Carbon::createFromFormat('Y-m-d', $day);
                if($day->between($start_at,$endDate) ){
                    $total+= 1;
                }
                if($day->between($start_at,$endDate) && (in_array(lcfirst(date('D',strtotime($day))),$week_end) || in_array(lcfirst(date('D',strtotime($day))),$vacations) )){
                    $off+= 1;
                }
            }
            $subscriptionDays = $total  - $off;
            $inputData = $request->all();
            $inputData['subscription_id'] = $id;
            $inputData['start_at'] = $start_at;
            $inputData['end_at'] = $pauseEnd;

            if($subscriptionDays){
                $currentSubscription->update([
                    'pause_start_at' => $start_at,
                    'pause_end_at' => $pauseEnd,
                    'permanent_pause_days'  => $subscriptionDays,
                    'end_at' => $pauseEnd,
                ]);

                $inputData['notes'] = $request->notes;
                Suspension::create($inputData);
            }

            DB::commit();
            return redirect()->back()->with([true, __('apps::dashboard.messages.created')]);

        } catch (\PDOException $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->errorInfo[2]);
        }
//        return Response()->json([true, __('apps::dashboard.messages.created')]);
    }
}
