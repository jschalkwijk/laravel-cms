<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use ModelActionsTrait;

    protected $primaryKey = 'tag_id';
	protected $fillable = ['title'];
	public $table = "tags";
	# Relations
	public function taggable()
	{
		return $this->morphTo();
	}
	public function user()
	{
		return $this->belongsTo(User::class,'user_id');
	}

	public function posts()
	{
		return $this->morphedByMany('JornSchalkwijk\LaravelCMS\Models\Post', 'taggable_id');
	}

	/**
	 * Get all of the videos that are assigned this tag.
	 */
	public function products()
	{
		return $this->morphedByMany('JornSchalkwijk\LaravelCMS\Models\Product', 'taggable_id');
	}
	# Getters
	public function id()
	{
		return $this->tag_id;
	}

	public function getLink(){
		return preg_replace("/[\s-]+/", "-", $this->title);
	}
}
