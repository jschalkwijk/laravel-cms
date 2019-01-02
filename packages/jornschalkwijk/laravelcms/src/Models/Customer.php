<?php

    namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = "customer_id";
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_1',
        'phone_2',
        'dob',
        'address_id',
        'created_at',
        'updated_at',
    ];

    public $table = "orders";

    #relations
    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id','customer_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class,'customer_id','customer_id');
    }
}
