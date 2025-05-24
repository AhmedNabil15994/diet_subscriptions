<?php

namespace Modules\Package\Http\Controllers\Dashboard;


use Illuminate\Routing\Controller;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Package\Entities\Subscription;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Package\Entities\Suspension;
use Modules\Package\Http\Requests\Dashboard\SuspensionRequest;
use Modules\Package\Transformers\Dashboard\SubscriptionResource;

class SuspensionController extends Controller
{
    use CrudDashboardController;
    public function extraData($model)
    {
        return [
            'subscriptions' => Subscription::where('is_default', 1)
                ->with('user')
                ->get()
        ];
    }

    public function store(SuspensionRequest $request){
        $addDays = 0;
        $currentSubscription = Subscription::find($request->subscription_id);
        $startDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->start_at);
        $endDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->end_at);
        $pauseStart = Carbon::createFromFormat('Y-m-d', $request->start_at);
        $pauseEnd = Carbon::createFromFormat('Y-m-d', $request->end_at);
        $stopDates = getDaysArray($pauseStart,$pauseEnd);

        $week_end = [];
        $vacations = [];
        if(setting('week_end')){
            $week_end = setting('week_end');
        }
        if( setting('vacation')){
            $vacations = setting('vacation')['date_range'][array_keys(setting('vacation')['date_range'])[0]];
            $vacations = explode(' - ',$vacations);
        }
        if($pauseStart->between($startDate,$endDate) && $pauseEnd->between($startDate,$endDate)){
            $def = Carbon::parse($pauseStart)->diffInDays($pauseEnd);
            foreach ($stopDates as $day){
                if(count($vacations)){
                    $vacationsStartDate = Carbon::createFromFormat('Y-m-d', $vacations[0] > $vacations[1] ? $vacations[1] : $vacations[0]);
                    $vacationsEndDate = Carbon::createFromFormat('Y-m-d', $vacations[0] > $vacations[1] ? $vacations[0] : $vacations[1]);
                    $day = Carbon::createFromFormat('Y-m-d', $day);
                    if($day->between($pauseStart,$pauseEnd) || in_array(lcfirst(date('D',strtotime($day))),$week_end)){
                        $addDays+= 1;
                    }
                }
            }

            $inputData = $request->validated();
            if($addDays > 0){
                $request->end_at = date('Y-m-d',strtotime('+'.($def > 1 ? $addDays : $def).' days',strtotime($request->end_at)));
                $inputData['end_at'] = $request->end_at;
            }

            if($def > $currentSubscription->max_puse_days){
                return Response()->json([false, __('package::frontend.pause_p1')]);
            }
            $currentSubscription->update([
                'pause_start_at' => $request->start_at,
                'pause_end_at' => $request->end_at,
                'end_at' => Carbon::parse($currentSubscription->end_at)->addDays($def)->toDateString(),
            ]);

            $inputData['notes'] = $request->notes;
            $this->model->create($inputData);
            return Response()->json([true, __('apps::dashboard.messages.created')]);
        }else{
            return Response()->json([false, __('package::dashboard.suspensions.messages.pause_p3')]);
        }

        return Response()->json([true, __('apps::dashboard.messages.created')]);
    }

    public function update(SuspensionRequest $request,$id){
        $addDays = 0;
        $currentSubscription = Subscription::find($request->subscription_id);
        $startDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->start_at);
        $endDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->end_at);
        $pauseStart = Carbon::createFromFormat('Y-m-d', $request->start_at);
        $pauseEnd = Carbon::createFromFormat('Y-m-d', $request->end_at);
        $stopDates = getDaysArray($pauseStart,$pauseEnd);

        $week_end = [];
        $vacations = [];
        if(setting('week_end')){
            $week_end = setting('week_end');
        }
        if( setting('vacation')){
            $vacations = setting('vacation')['date_range'][array_keys(setting('vacation')['date_range'])[0]];
            $vacations = explode(' - ',$vacations);
        }
        if($pauseStart->between($startDate,$endDate) && $pauseEnd->between($startDate,$endDate)){
            $def = Carbon::parse($pauseStart)->diffInDays($pauseEnd);
            foreach ($stopDates as $day){
                if(count($vacations)){
                    $vacationsStartDate = Carbon::createFromFormat('Y-m-d', $vacations[0] > $vacations[1] ? $vacations[1] : $vacations[0]);
                    $vacationsEndDate = Carbon::createFromFormat('Y-m-d', $vacations[0] > $vacations[1] ? $vacations[0] : $vacations[1]);
                    $day = Carbon::createFromFormat('Y-m-d', $day);
                    if($day->between($pauseStart,$pauseEnd)){
                        $addDays+= 1;
                    }else if(in_array(lcfirst(date('D',strtotime($day))),$week_end)){
                        $addDays+= 1;
                    }
                }
            }

            $inputData = $request->validated();
            if($addDays > 0){
                $request->end_at = date('Y-m-d',strtotime('+'.$addDays.' days',strtotime($request->end_at)));
                $inputData['end_at'] = $request->end_at;
            }

            if($def > $currentSubscription->max_puse_days){
                return Response()->json([false, __('package::frontend.pause_p1')]);
            }
            $currentSubscription->update([
                'pause_start_at' => $request->start_at,
                'pause_end_at' => $request->end_at,
                'end_at' => Carbon::parse($currentSubscription->end_at)->addDays($def)->toDateString(),
            ]);

            $inputData['notes'] = $request->notes;
            $this->model->find($id)->update($inputData);
            return Response()->json([true, __('apps::dashboard.messages.created')]);
        }else{
            return Response()->json([false, __('package::frontend.pause_p3')]);
        }

        return Response()->json([true, __('apps::dashboard.messages.updates')]);
    }
}
