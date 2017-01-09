<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
	protected $fillable = ['title','description'];
	public $table = "categories";
	# Relations
//	public function posts() {
//		return $this->hasMany(Post::class);
//    }
//
//	public function products() {
//		return $this->hasMany(Product::class);
//	}
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function posts()
	{
		return $this->morphedByMany('CMS\Models\Post', 'categoryable_id');
	}

	/**
	 * Get all of the videos that are assigned this tag.
	 */
	public function products()
	{
		return $this->morphedByMany('CMS\Models\Product', 'categoryable_id');
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
