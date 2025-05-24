<?php

namespace Modules\Package\Entities;

use Carbon\Carbon;
use Modules\User\Entities\User;
use Modules\Core\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Transaction\Entities\Transaction;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Package\Entities\SubscriptionCoupon;

class Subscription extends Model
{
    protected $guarded = ["id"];
    protected $appends = ["is_pause","price_after_vat"];


    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function packagePrice()
    {
        return $this->belongsTo(PackagePrice::class,'package_price_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->morphOne(Transaction::class, 'transaction');
    }

    public function address()
    {
        return $this->hasOne(SubscriptionAddress::class);
    }

    /**
     * Get all of the suspensions for the Subscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function suspensions(): HasMany
    {
        return $this->hasMany(Suspension::class);
    }

    public function coupon()
    {
        return $this->hasOne(SubscriptionCoupon::class, 'subscription_id');
    }

    public function getPriceAfterVatAttribute()
    {
        return $this->coupon ?
            $this->price - ($this->coupon->discount_type != 'value' ? ($this->price * ($this->coupon->discount_percentage/100) )  : $this->coupon->discount_value)  :
            $this->price;
    }

    public function scopeToday($query)
    {
        return
        $query
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->whereNull('pause_start_at');
                $query->whereNull('pause_end_at');
            });
            $query->orWhere(function ($query) {
                $query->whereDate('pause_start_at','>', Carbon::now()->addDay()->toDateString());
                $query->orWhereDate('pause_end_at','<=', Carbon::now()->addDay()->toDateString());
            });
        })
        ->where(function ($query) {
            $query->whereDate('start_at','<=', Carbon::now()->addDay()->toDateString());
            $query->whereDate('end_at','>=',Carbon::now()->addDay()->toDateString());
        });
    }

    public function scopeAfterTomorrow($query)
    {
        return
        $query
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->whereNull('pause_start_at');
                $query->whereNull('pause_end_at');
            });
            $query->orWhere(function ($query) {
                $query->whereDate('pause_start_at','>', Carbon::now()->addDays(2)->toDateString());
                $query->orWhereDate('pause_end_at','<=', Carbon::now()->addDays(2)->toDateString());
            });
        })
        ->where(function ($query) {
            $query->whereDate('start_at','<=', Carbon::now()->addDays(2)->toDateString());
            $query->whereDate('end_at','>=',Carbon::now()->addDays(2)->toDateString());
        });
    }


    public function getIsPauseAttribute()
    {

        if($this->pause_start_at){

            $startDate = Carbon::createFromFormat('Y-m-d', $this->pause_start_at);
            if($this->pause_end_at){
                $endDate = Carbon::createFromFormat('Y-m-d', $this->pause_end_at);
                if(Carbon::now()->between($startDate,$endDate)){
                    return true;
                }
            }else{
                if($startDate){
                    return true;
                }
            }
        }

        return  false;
    }

     protected static function boot()
     {
         parent::boot();
         static::saved(function ($model) {
            self::where('id','!=', $model->id)->whereUserId($model->user_id)->where('paid','!=','paid')->update(['is_default'=>0]);
         });
     }

    public function createAddress($request)
    {
        $this->address()->create($request->only(['state_id','street','block','building','gada']));
    }
}
