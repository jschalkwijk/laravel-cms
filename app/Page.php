<?php

namespace CMS;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $primaryKey = 'page_id';
    public $table = 'pages';
    protected $fillable = ['title','description','content','created_at','updated_at'];
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
        return $this->page_id;
    }
}
