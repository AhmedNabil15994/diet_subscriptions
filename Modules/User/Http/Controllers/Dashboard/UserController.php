<?php

namespace Modules\User\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use IlluminateAgnostic\Arr\Support\Carbon;
use Modules\Core\Packages\SMS\SmsBox;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Package\Entities\Subscription;
use Modules\Package\Entities\Suspension;
use Modules\Package\Http\Requests\Dashboard\PauseRequest;
use Modules\Package\Transformers\Dashboard\SubscriptionResource;
use Modules\Package\Transformers\Dashboard\SuspensionResource;
use Modules\Transaction\Transformers\Dashboard\TransactionResource;
use Modules\User\Entities\User;

class UserController extends Controller
{
    use CrudDashboardController;

    public function sendOTP($id){
        $id = (int) $id;
        $user = $this->repository->findById($id);
        $data['code_verified'] = rand(1000, 9000);
        $user->update($data);
        if (app()->environment('production', 'staging')) {
            try {
                app(SmsBox::class)->send($data['code_verified'], $user->mobile);
            } catch (Exception $e) {
                info($e->getMessage());
            }
        }
        \Session::flash('message', __('apps::dashboard.messages.codeSent'));
        return redirect()->back();
    }

    public function getActiveSubscriptions($id)
    {
        $id = (int) $id;
        $user = $this->repository->findById($id);
        return response()->json([
            'subscriptions'  => SubscriptionResource::collection($user?->activeSubscriptions ?? []),
        ]);
    }

    public function show($id) {
        $model = $this->repository->findById($id);
        if(!$model){
            abort(404);
        }
        $userData['subscriptions'] = SubscriptionResource::collection($model->subscriptions);
        $userData['suspensions'] = SuspensionResource::collection($this->repository->suspensions($id));
        $userData['transactions'] = TransactionResource::collection($this->repository->transactions($id));
        return view('user::dashboard.users.show',compact('model','userData'));
    }

    public function pauseActiveSubscriptions(PauseRequest $request)
    {
        try {
            DB::beginTransaction();
            $start_at = $request->start_at ? $request->start_at : date('Y-m-d');
            $subscriptionDays = 0;
            $addDays = 0;

            $currentSubscription = Subscription::find($request->subscription_id);
            $startDate = \IlluminateAgnostic\Collection\Support\Carbon::createFromFormat('Y-m-d', $currentSubscription->start_at);
            $endDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->end_at);
            $pauseStart = Carbon::createFromFormat('Y-m-d', $start_at);
            $pauseEnd = $request->end_at ? Carbon::createFromFormat('Y-m-d', $request->end_at) : null;

            $inputData = $request->validated();
            $inputData['subscription_id'] = $request->subscription_id;
            $inputData['start_at'] = $start_at;
            $inputData['end_at'] = $pauseEnd;
            $inputData['notes'] = $request->notes;

            $week_end = [];
            $vacations = [];
            if(setting('week_end')){
                $week_end = setting('week_end');
            }
            if( setting('vacation')){
                $vacations = setting('vacation')['date_range'][array_keys(setting('vacation')['date_range'])[0]];
                $vacations = explode(' - ',$vacations);
            }

            if($pauseEnd){
                $stopDates = getDaysArray($pauseStart,$pauseEnd);
                $def = \IlluminateAgnostic\Collection\Support\Carbon::parse($pauseStart)->diffInDays($pauseEnd);
                foreach ($stopDates as $day){
                    $day = \IlluminateAgnostic\Collection\Support\Carbon::createFromFormat('Y-m-d', $day);
                    if(count($vacations)){
                        if($day->between($pauseStart,$pauseEnd) && (in_array(lcfirst(date('D',strtotime($day))),$week_end) || in_array(lcfirst(date('D',strtotime($day))),$vacations) )){
                            $addDays+= 1;
                        }
                    }else{
                        if($day->between($pauseStart,$pauseEnd) && in_array(lcfirst(date('D',strtotime($day))),$week_end) ){
                            $addDays+= 1;
                        }
                    }
                }

                $inputData = $request->validated();
                if($addDays > 0){
                    $request->end_at = date('Y-m-d',strtotime('+'.($def > 1 ? $addDays : $def).' days',strtotime($request->end_at)));
                    $inputData['end_at'] = $request->end_at;
                }

                if($addDays){
                    $currentSubscription->update([
                        'pause_start_at' => $request->start_at,
                        'pause_end_at' => $request->end_at,
                        'end_at' => \IlluminateAgnostic\Collection\Support\Carbon::parse($currentSubscription->end_at)->addDays($def)->toDateString(),
                    ]);
                    Suspension::create($inputData);
                    DB::commit();
                }
            }else{
                $subscriptionDays = 0;
                $total = 0;
                $off = 0;
                $supscriptionDates = getDaysArray($startDate,$endDate);
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
                if($subscriptionDays){
                    $currentSubscription->update([
                        'pause_start_at' => $start_at,
                        'pause_end_at' => $pauseEnd,
                        'permanent_pause_days'  => $subscriptionDays,
                        'end_at' => $pauseEnd,
                    ]);

                    Suspension::create($inputData);
                    DB::commit();
                }
            }

            return Response()->json([true, __('apps::dashboard.messages.created')]);
        } catch (\PDOException $e) {
            DB::rollback();
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}
