<?php

namespace Modules\Coupon\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Coupon;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;

class CouponController extends Controller
{
    /*
     *** Start - Check Frontend Coupon
     */
    public function checkCoupon(Request $request,$packagePrice)
    {
       
        $packagePrice = PackagePrice::findOrFail($packagePrice);
        $package = $packagePrice->package;

        $couponData = $this->getCouponData($request->code,$packagePrice,$package);

        return response()->json($couponData[1], ($couponData[0] ? 200 : 422));
    }

    protected function getProductsList($coupon, $flag = 'products')
    {
        $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];
        $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];

        $products = Package::where('status', true);

        if ($flag == 'products') {
            $products = $products->whereIn('id', $coupon_products);
        }

        if ($flag == 'categories') {
            $products = $products->whereHas('categories', function ($query) use ($coupon_categories) {
                $query->active();
                $query->whereIn('categorized.category_id', $coupon_categories);
            });
        }

        return $products->get(['id']);
    }

    private function addProductCouponCondition($prdId,$price, $coupon, $prdListIds = [])
    {
        $discount_value = 0;
        if (count($prdListIds) > 0 && in_array($prdId, $prdListIds)) {

            if ($coupon->discount_type == "value") {
                $discount_value = $coupon->discount_value;
            } elseif ($coupon->discount_type == "percentage") {
                $discount_value = (floatval($price) * $coupon->discount_percentage) / 100;
            }
        }
        return $discount_value;
    }

    public function getCouponData($code,$packagePrice, $package)
    {
        $coupon = Coupon::where('code', $code)->where(function($query){
            $query->where(function($query){
                
                $query->where('start_at', '<=', date('Y-m-d'));
                $query->where('expired_at', '>', date('Y-m-d'));
            });
            $query->orWhere(function($query){
                
                $query->whereNull('start_at');
                $query->where('expired_at', '>', date('Y-m-d'));
            });
            $query->orWhere(function($query){
                
                $query->where('start_at', '<=', date('Y-m-d'));
                $query->whereNull('expired_at');
            });
            $query->orWhere(function($query){
                
                $query->whereNull('start_at');
                $query->whereNull('expired_at');
            });
        })->active()->first();

        if ($coupon) {
            $coupon_users = $coupon->users->pluck('id')->toArray() ?? [];
            if ($coupon_users <> []) {
                if (auth()->check() && !in_array(auth()->id(), $coupon_users))
                    return [false,["errors" => __('coupon::frontend.coupons.validation.code.custom')]];
            }
            
            if (!is_null($coupon->flag)) {
                $prdList = $this->getProductsList($coupon, $coupon->flag);
                $prdListIds = array_values(!empty($prdList) ? array_column($prdList->toArray(), 'id') : []);
                $discount_value = $this->addProductCouponCondition($package->id,$packagePrice->active_price['price'], $coupon, $prdListIds);
               
            } else {
                $discount_value = 0;
                if ($coupon->discount_type == "value")
                    $discount_value = $coupon->discount_value;
                elseif ($coupon->discount_type == "percentage")
                    $discount_value = ($packagePrice->active_price['price'] * $coupon->discount_percentage) / 100;
            }

            $total = $packagePrice->active_price['price'] - $discount_value;

            $data = [
                "coupon_value" => $discount_value,
                "total" => $total,
                "message" => "

                    <div class=\"alert alert-success\" role=\"alert\" style=\"margin: 0px 12px;\">
                        ".__('coupon discount').": {$discount_value} KW, ".__('Total after discount').": {$total} KW
                    </div>
                ",
            ];

            return [true,["message" => __('coupon::frontend.coupons.checked_successfully'), "data" => $data],$coupon];
        } else {
            return [false,["errors" => __('coupon::frontend.coupons.validation.code.not_found')]];
        }
    }

    /*
     *** End - Check Frontend Coupon
     */
}
