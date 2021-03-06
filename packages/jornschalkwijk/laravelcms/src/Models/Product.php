<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = "product_id";
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'description',
        'specifications',
        'discount_percentage',
        'discount_value',
        'tax_percentage',
        'tax_value',
        'folder_id',
        'stock',
    ];

    public $table = "products";

    # Relations

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function tags()
    {
        return $this->morphToMany('JornSchalkwijk\LaravelCMS\Models\Tag', 'taggable',null,null,'tag_id');
    }

    public function folder()
    {

        return $this->hasOne(Folder::class,'folder_id','folder_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Product::class,'orders_products','product_id','order_id');
    }

    # Getters
    public function id()
    {
        return $this->product_id;
    }

    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }

    public function setTaxValue(){
        if($this->discount_percentage > 0) {
            return $this->tax_value = (($this->price - $this->discount_value)) * $this->tax_percentage / 100;
        }
        return $this->tax_value = ($this->price * $this->tax_percentage) / 100;
    }

    public  function setDiscount(){
        $this->discount_value = ($this->price / 100) * $this->discount_percentage;
        $this->discount_price = $this->price - $this->discount_value;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($value)
    {
        $this->quantity = $value;
    }

    public function total(){

        if($this->discount_percentage > 0){
            return $this->discount_price + $this->tax_value;
        }
        return $this->price + $this->tax_value;
    }
    // SHOPPING Stock
    public function lowStock()
    {
        if($this->outOfStock()){
            return false;
        }

        return (bool) ($this->stock < 5);

    }
    public function outOfStock()
    {
        return (bool) ($this->stock== 0);
    }
    public function inStock()
    {
        return $this->stock >= 1;
    }
    public function hasStock($quantity){
        if($this->stock >= $quantity){
            return true;
        }
    }
    // total of the product price * the quantity orderd.
    public function productTotal(){
        return $this->getQuantity() * $this->Total();
    }

    public function setMaxStock($num){
        $this->maxStock = $num;
    }
    public function maxStock(){
        return $this->maxStock;
    }
}
