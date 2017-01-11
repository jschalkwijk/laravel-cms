<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'post_id';
	protected $fillable = [
        'title',
        'content',
        'description',
        'keywords'
    ];
    public $table = "posts";

    # Relations

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->morphToMany('CMS\Models\Category', 'categoryable');
    }

    public function tags()
    {
        return $this->morphToMany('CMS\Models\Tag', 'taggable');
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
