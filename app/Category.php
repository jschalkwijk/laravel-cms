<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Category extends Model
{
      protected $primaryKey = 'category_id';
	  
	  public function posts() {
		return $this->hasMany(Post::class);
	}
}
