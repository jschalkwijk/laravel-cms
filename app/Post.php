<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    protected $primaryKey = 'post_id';
	protected $fillable =['title','content','description','keywords'];
    public $dbt = "posts";

	public function category(){
		return $this->belongsTo(Category::class,"category_id","category_id");
	}
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
