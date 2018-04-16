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
        return $this->belongsTo(Category::class);
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
}
