<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Database\Eloquent\Model;
use PayPal\Api\Order;

class Address extends Model
{
    protected $primaryKey = "address_id";
    protected $fillable = [
        'address_1',
        'address_2',
        'postal',
        'city',
        'customer_id',
        'created_at',
        'updated_at',
    ];

//    public $table = "addresses";

    #relations
    public function orders()
    {
        return $this->belongsTo(Order::class,'address_id','order_id');
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class,'addresses_customers','address_id','customer_id');
    }
}
