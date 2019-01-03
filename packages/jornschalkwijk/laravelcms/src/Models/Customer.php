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

//    public $table = "customers";
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    #relations
    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id','customer_id');
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class,'addresses_customers','customer_id','address_id');
    }
}
