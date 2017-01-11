<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = "product_id";
    protected $fillable = [
        'name',
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
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->morphToMany('CMS\Models\Category', 'categoryable');
    }

    public function tags()
    {
        return $this->morphToMany('CMS\Models\Tag', 'taggable');
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
