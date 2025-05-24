<?php

namespace Modules\User\Entities;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Modules\Package\Entities\Subscription;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\DeviceToken\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasMedia
{
    use CrudModel {
        __construct as private CrudConstruct;
    }

    use Notifiable, HasRoles, InteractsWithMedia, HasApiTokens;

    use SoftDeletes {
        restore as private restoreB;
    }
    protected $guard_name = 'web';
    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image',
        'code_verified',
        'is_verified',
        'mobile_country'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile', 'image']);
    }

    public function setImageAttribute($value)
    {
        if (!$value) {
            $this->attributes['image'] = '/uploads/users/user.png';
        }
        $this->attributes['image'] = $value;
    }

    public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, "user_id");
    }

    public function currentSubscription()
    {
        return $this->hasOne(Subscription::class, "user_id")->where('paid','paid')->with('coupon')->where("is_default",true)->orderBy('id','DESC');
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(Subscription::class, "user_id")->where('paid','paid')->with('coupon')->where("end_at",'>',date('Y-m-d'))->orderBy('id','DESC');
    }

    public function restore()
    {
        $this->restoreB();
    }
}
