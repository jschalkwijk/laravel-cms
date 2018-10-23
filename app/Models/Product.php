<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
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
        'discount_price',
        'savings',
        'tax_percentage',
        'tax',
        'total',
        'img_path',
        'folder_id',
        'quantity',
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
        return $this->morphToMany('CMS\Models\Tag', 'taggable',null,null,'tag_id');
    }

    # Getters
    public function id()
    {
        return $this->product_id;
    }

    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }

    public function getTax(){
        $this->tax = ($this->price * $this->tax_percentage) / 100;
        return $this->tax;
    }

    protected function discount($percentage){
        $this->discount_price = ($this->price / 100) * $percentage;
        $this->savings = $this->price * $percentage;
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
        return $this->price + $this->getTax();
    }
    // SHOPPING Stock
    public function lowStock()
    {
        if($this->outOfStock()){
            return false;
        }

        return (bool) $this->quantity < 5;

    }
    public function outOfStock()
    {
        return (bool) ($this->quantity == 0);
    }
    public function inStock()
    {
        return $this->quantity >= 1;
    }
    public function hasStock($quantity){
        if($this->quantity >= $quantity){
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
