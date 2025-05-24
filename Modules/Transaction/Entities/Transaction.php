<?php

namespace Modules\Transaction\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\Subscription;

class Transaction extends Model
{
    protected $fillable = [
      'auth',
      'method' ,
      'tran_id' ,
      'result' ,
      'post_date' ,
      'ref' ,
      'track_id' ,
      'payment_id' ,
      'transaction_type' ,
      'transaction_id',
    ];

    public function transaction()
    {
        return $this->morphTo();
    }

    public function Subscription()
    {
        return $this->belongsTo(Subscription::class , 'transaction_id','id');
    }
}
