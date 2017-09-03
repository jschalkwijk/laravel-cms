<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
	protected $fillable = ['title','description'];
	public $table = "categories";
	# Relations
	public function posts() {
		return $this->hasMany(Post::class,'post_id');
    }

	public function products() {
		return $this->hasMany(Product::class,'product_id');
	}
    public function child() {
        return $this->hasOne(Category::class,'category_id','parent_id');
    }
//	public function categoryable()
//	{
//		return $this->morphTo();
//	}
	public function user()
	{
		return $this->belongsTo(User::class,'user_id');
	}

	# Getters
	public function id()
	{
		return $this->category_id;
	}

	public function getLink(){
		return preg_replace("/[\s-]+/", "-", $this->title);
	}
}
