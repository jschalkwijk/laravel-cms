<?php

    namespace JornSchalkwijk\LaravelCMS\Models;

    use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
    use Illuminate\Database\Eloquent\Model;
    use ScoutElastic\Searchable;
    use JornSchalkwijk\LaravelCMS\Models\Elasticsearch\OrderIndexConfigurator;

    class Order extends Model
    {
        use ModelActionsTrait;
        use Searchable;

        protected $indexConfigurator = OrderIndexConfigurator::class;

        protected $primaryKey = "order_id";
        protected $fillable = [
            'hash',
            'total',
            'paid',
            'customer_id',
            'address_id',
            'billing_address_id',
            'created_at',
            'updated_at',
        ];

        public $table = "orders";
        // Here you can specify a mapping for a model fields.
        protected $mapping = [
            'properties' => [
                'order_id' => [
                    'type' => 'integer',
                    'index' => 'not_analyzed',
                ],
                'hash' => [
                    'type' => 'string',
                    'index' => 'not_analyzed'
                ],
                'total' => [
                    'type' => 'float',
                    'index' => 'not_analyzed'
                ],
                'paid' => [
                    'type' => 'boolean',
                    'index' => 'not_analyzed'
                ],
                'address_id' => [
                    'type' => 'integer',
                    'index' => 'not_analyzed'
                ],
                'customer_id' => [
                    'type' => 'integer',
                    'index' => 'not_analyzed'
                ],
                'created_at' => [
                    'type' => 'date',
                    'format' => 'yyyy-MM-dd HH:mm:ss',
                    'index' => 'not_analyzed'
                ],
                'updated_at' => [
                    'type' => 'date',
                    'format' => 'yyyy-MM-dd HH:mm:ss',
                    'index' => 'not_analyzed'
                ]
            ]
        ];
        #relations
        public function products()
        {
            return $this->belongsToMany(Product::class,'orders_products','order_id','product_id')->withPivot('quantity');
        }

        public function customer()
        {
            return $this->belongsTo(Customer::class,'customer_id');
        }

        public function address()
        {
            $this->hasOne(Address::class,'address_id','address_id');
        }
        public function billing_address()
        {
            $this->hasOne(Address::class,'address_id','billing_address_id');
        }
    }