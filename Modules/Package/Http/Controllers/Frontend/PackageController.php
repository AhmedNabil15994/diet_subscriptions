<?php

namespace Modules\Package\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use IlluminateAgnostic\Collection\Support\Carbon;
use Modules\Coupon\Http\Controllers\Frontend\CouponController;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;
use Modules\Transaction\Services\CbkPaymentService;
use Modules\Transaction\Services\PaymentService;

use Modules\Area\Repositories\FrontEnd\CountryRepository;
use Modules\Authentication\Foundation\Authentication;
use Modules\Package\Http\Requests\Frontend\{SubscribeRequest,PauseSubscriptionRequest};
use Modules\Package\Repositories\Frontend\PackageRepository;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository;

class PackageController extends Controller
{
    use Authentication;

    protected $country;

    public function __construct(public PackageRepository $packageRepository, CountryRepository $country, public CbkPaymentService $payment, public AuthenticationRepository $auth)
    {
        $this->country = $country;
        $this->middleware('auth')->only(['subscribeForm', 'subscribe', 'renew','pauseSubscription']);
    }



    public function index()
    {
        $packages =  $this->packageRepository->getAllPackages()->get();

        return view('package::frontend.index', compact('packages'));
    }
    public function show(Package $package)
    {
        return view('package::frontend.show', compact('package'));
    }
    public function subscribeForm($packagePrice,Request $request)
    {
        if($request->start){
            session()->put('start',$request->start);
        }
        $packagePrice = PackagePrice::findOrFail($packagePrice);
        $package = $packagePrice->package;
        $countries = $this->country->getAllSuported();
        return view('package::frontend.subscribe', compact('package','packagePrice','countries'));
    }

    public function subscribe(SubscribeRequest $request, $packagePrice)
    {
        if (!auth()->check()) {
            $this->auth->register($request->validated());
            $this->loginAfterRegister($request);
        }
        $packagePrice = PackagePrice::findOrFail($packagePrice);
        $package = $packagePrice->package;

        if($request->coupon_code){
            $coupon_data = (new CouponController)->getCouponData($request->coupon_code,$packagePrice,$package);
        }else{
            $coupon_data = null;
        }

        $subscription =  $package
            ->createSubscriptions(
                auth()->id(),
                $packagePrice,
                $coupon_data,
                false,
                [
                    'start_at' => date('Y-m-d',strtotime( session()->has('start') ? session()->get('start') : $request->start_date)),
                    'note' => $request->note,
                    'paid' => $package->is_free ? 'paid' : 'pending',
                ]
            );
        $subscription->refresh();
        $subscription->createAddress($request);
        if ($package->is_free) {
            countMaxOrders();
            return redirect()->route('frontend.subscriptions.index')
                ->with('alert', 'success')
                ->with('msg', __('you subscribed successfully'));
        }

        $url = $this->payment->send($subscription, 'orders', $request['payment'],($coupon_data && $coupon_data[0] ? $coupon_data[1]['data']['total'] : null));
        session()->forget('start');
        return Response()->json([true, 'Redirect to get way', 'url' => $url]);
    }

    public function renew(Request $request)
    {
        $currentSubscription = auth()->user()->currentSubscription?->load('package');

        $package =  $currentSubscription->package;
        $data =
            [
                'start_at' => $request->start_date,
                'paid' => 'pending',
                'renew_from_count' => (++$currentSubscription->renew_from_count),
            ];

        if($currentSubscription->renew_from_count <= $currentSubscription->same_pricerenew_times)
            $data['price'] = $currentSubscription->price;

        $subscription = $package->createSubscriptions(auth()->id(), $currentSubscription->packagePrice, false,false, $data);

        if ($package->is_free) {
            return redirect()->route('frontend.subscriptions.index')
                ->with('alert', 'success')
                ->with('msg', __('you subscribed successfully'));
        }

        $url = $this->payment->send($subscription, 'orders', $request['payment']);

        return redirect($url);
    }

    public function pauseSubscription(PauseSubscriptionRequest $request)
    {
        $currentSubscription = auth()->user()->currentSubscription?->load('package');
        $addDays = 0;
        $startDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->start_at);
        $endDate = Carbon::createFromFormat('Y-m-d', $currentSubscription->end_at);
        $pauseStart = Carbon::createFromFormat('Y-m-d', $request->pause_start_at);
        $pauseEnd = Carbon::createFromFormat('Y-m-d', $request->pause_end_at);
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
                if($addDays > 0){
                    $request->pause_end_at = date('Y-m-d',strtotime('+'.($def > 1 ? $addDays : $def).' days',strtotime($request->pause_end_at)));
                }

                if($def > $currentSubscription->max_puse_days){
                    return redirect()->route('frontend.subscriptions.index')
                    ->with('alert', 'danger')
                    ->with('msg', trans('package::frontend.pause_p1')."{$currentSubscription->max_puse_days}");
                }
                $currentSubscription->update([
                    'pause_start_at' => $request->pause_start_at,
                    'pause_end_at' => $request->pause_end_at,
                    'end_at' => Carbon::parse($currentSubscription->end_at)->addDays($def)->toDateString(),
                ]);
                return redirect()->route('frontend.subscriptions.index')
                ->with('alert', 'success')
                ->with('msg', trans('package::frontend.pause_p2'));
        }else{
            return redirect()->route('frontend.subscriptions.index')
                ->with('alert', 'danger')
                ->with('msg',  trans('package::frontend.pause_p3'));
        }
    }
}
