<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
	protected $fillable = ['title','description'];
	public $table = "categories";

	public function posts() {
		return $this->hasMany(Post::class);
    }

	public function getLink(){
		return preg_replace("/[\s-]+/", "-", $this->title);
	}

	public function id()
	{
		return $this->category_id;
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
