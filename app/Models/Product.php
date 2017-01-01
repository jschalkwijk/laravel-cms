<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
    ];

    public $table = "products";

    # Relations
    public function category(){
        return $this->belongsTo(Category::class,"category_id","category_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # Getters
    public function id()
    {
        return $this->product_id;
    }
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }
}
