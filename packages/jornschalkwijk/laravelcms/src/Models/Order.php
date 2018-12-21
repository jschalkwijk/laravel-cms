<?php

    namespace JornSchalkwijk\LaravelCMS\Models;

    use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
    use Illuminate\Database\Eloquent\Model;

    class Order extends Model
    {
        use ModelActionsTrait;
        protected $primaryKey = "order_id";
        protected $fillable = [
            'hash',
            'total',
            'paid',
            'customer_id',
            'address_id',
            'created_at',
            'updated_at',
        ];

        public $table = "orders";

        #relations
        public function products()
        {
            return $this->belongsToMany(Product::class,'orders_products','order_id','product_id');
        }
    }