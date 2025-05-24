<?php

namespace Modules\Package\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Order\Events\ActivityLog;
use Modules\Package\Entities\Subscription;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Transaction\Services\CbkPaymentService;

class AfterPaidController extends ApiController
{
    private $payment;

    public function __construct(CbkPaymentService $payment)
    {
        $this->payment = $payment;
    }
    public function success(Request $request)
    {
        return $this->updatePaidStatus($request);

    }

    public function failed(Request $request)
    {
        return $this->updatePaidStatus($request);
    }



    public function updatePaidStatus(Request $request)
    {
        try {
            $request = $this->payment->verifyPayment($request->encrp);
            if (isset($request['PayId'])) {

                $model = Subscription::find($request['PayId']);

                DB::beginTransaction();

                if ($model) {

                    $status['paid'] = isset($request['Status']) && $request['Status'] == '1' ? 'paid' : 'failed';
                    $status['is_default'] = isset($request['Status']) && $request['Status'] == '1' ? true : false;
                    $model->update($status);
                    $model->transactions()->updateOrCreate([
                        'payment_id' => $request['PaymentId'],
                    ], [
                        'method'    => $request['PayType'],
                        'payment_id' => $request['PaymentId'],
                        'tran_id' => $request['PayId'],
                        'result' => '',
                        'post_date' => '',
                        'ref' => $request['ReferenceId'],
                        'track_id' => $request['TrackId'],
                    ]);

                    if(isset($request['Status']) && $request['Status'] == '1'){

                        Subscription::where("user_id", $model->user_id)
                            ->where("id", "!=", $model->id)
                            ->update(["is_default" => false]);
                    }

                    DB::commit();

                    countMaxOrders();
                    isset($request['Status']) && $request['Status'] == '1' ? countMaxOrders() : null;

                    return isset($request['Status']) && $request['Status'] == '1' ?

                        redirect()->route('frontend.subscriptions.index')
                            ->with('alert', 'success')
                            ->with('msg', __('you subscribed successfully'))
                        :

                        redirect()->route('frontend.home')
                            ->with('alert', 'filed')
                            ->with('msg', __('you subscribed field'));
                }
            }

            return redirect()->route('frontend.home')
                ->with('alert', 'filed')
                ->with('msg', __('you subscribed field'));
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function fireLog($reservations_id)
    {
        $data = [
            'id' => $reservations_id,
            'type' => 'orders',
            'url' => url(route('dashboard.reservations.show', $reservations_id)),
            'description_en' => 'New Reservation',
            'description_ar' => 'حجز جديد',
        ];

        event(new ActivityLog($data));
    }
}
