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
		return $this->hasMany(Post::class);
    }

	public function products() {
		return $this->hasMany(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
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
