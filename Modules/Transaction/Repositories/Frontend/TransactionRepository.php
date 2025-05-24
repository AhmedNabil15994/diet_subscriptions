<?php

namespace Modules\Transaction\Repositories\Frontend;

use Modules\Transaction\Entities\Transaction;
use Hash;
use DB;

class TransactionRepository
{

    function __construct(Transaction $transaction)
    {
        $this->transaction   = $transaction;
    }

}
