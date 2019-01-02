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
        'billing_address_1',
        'billing_address_2',
        'billing_postal',
        'billing_city',
        'customer_id',
        'created_at',
        'updated_at',
    ];

    public $table = "orders";

    #relations
    public function orders()
    {
        return $this->hasMany(Order::class,'address_id','address_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class,'address_id','address_id');
    }
}
