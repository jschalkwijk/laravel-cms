<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'post_id';
	protected $fillable =['title','content','category_id','description','keywords'];
    public $table = "posts";

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
    public function id()
    {
        return $this->post_id;
    }

}
