<?php

namespace Modules\Package\Entities;

use Carbon\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Modules\Core\Traits\CoreHelpers;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Core\Traits\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model implements HasMedia
{
    use CrudModel;
    use SoftDeletes;
    use HasTranslations;
    use InteractsWithMedia;
    use CoreHelpers;
    protected $guarded = ["id"];
    public $translatable = ['title', 'description'];

    public function prices()
    {
        return $this->hasMany(PackagePrice::class, "package_id");
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, "package_id");
    }

    public function toDaySubscriptions()
    {
        return $this->hasMany(Subscription::class, "package_id")->ToDay();
    }
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorized', 'categorized');
    }
    public function createSubscriptions($user_id, $price,$coupon_data, $from_admin = false, $attribute = [])
    {
        $startAt = Carbon::parse($attribute['start_at']);
            
        $data = [
            "from_admin" => $from_admin,
            "paid" => $from_admin == false ? 'pending' : 'paid',
            "price" => $price->active_price['price'],
            "same_pricerenew_times" => $price->same_pricerenew_times,
            "max_puse_days" => $price->max_puse_days,
            "package_price_id" => $price->id,
            "start_at" => $startAt,
            "is_free" => $price->active_price['price'] <= 0,
            "user_id" => $user_id,
            "is_default" => $price->active_price['price'] <= 0 ? true : false,
        ];

        $data['end_at'] = $data['from_admin'] && isset($attribute['end_at']) ? Carbon::parse($attribute['end_at']) :
        $this->calculateEndAt($startAt, $price->days_count)->toDateString();
        $data = array_merge($data, $attribute);

        if($data['from_admin']){
            $data['paid'] = 'paid';
            $data['is_default'] = 1;
        }

        $subscription = $this->subscriptions()->create($data);

        if(!$data['from_admin']){
            $subscription->is_default = 0;
            $subscription->save();
        }


        if($coupon_data && $coupon_data[0]){
            $coupon = $coupon_data[2];
            $subscription->coupon()->create([
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_percentage' => $coupon->discount_percentage,
                'discount_value' => $coupon->discount_value
            ]);
        }
        if($price->active_price['price'] <= 0){
            Subscription::where("user_id", $user_id)
                ->where("id", "!=", $subscription->id)
                ->where("paid", "!=", 'paid')
            ->update(["is_default" => false]);
        }
        return $subscription;
    }


    public function ScopeCategories($q, $categories)
    {
        return $q->whereHas(
            'categories',
            fn ($q) => $q->whereIn('categorized.category_id', $categories)

        );
    }


    public function ScopeSearch($q, $search)
    {
        return $q
            ->where(
                fn ($query) =>
                $query
                    ->Where("title->" . locale(), 'like', '%' . $search . '%')
            );
    }
}
