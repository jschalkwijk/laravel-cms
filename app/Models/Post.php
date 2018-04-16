<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use ModelActionsTrait;

    protected $primaryKey = 'post_id';
	protected $fillable = [
        'title',
        'content',
        'description',
        'keywords',
        'category_id',
    ];
    public $table = "posts";

    # Relations

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }

    public function tags()
    {
        return $this->morphToMany('CMS\Models\Tag', 'taggable',null,null,'tag_id');
    }
    # Getters
    public function id()
    {
        return $this->post_id;
    }
    public function getLink(){
        return preg_replace("/[\s-]+/", "-", $this->title);
    }

}
