<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'order_id',
        'failed',
        'transaction_id'
    ];

    public function order()
    {
        $this->belongsTo(Order::class,'order_id','order_id');
    }
}
