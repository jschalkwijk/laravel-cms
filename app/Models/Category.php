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
		return $this->hasMany(Post::class,'post_id');
    }

	public function products() {
		return $this->hasMany(Product::class,'product_id');
	}
    public function parent() {
        return $this->hasOne(Category::class,'category_id','parent_id');
    }
    public function children() {
        return $this->hasMany(Category::class,'parent_id','category_id');
    }
//	public function categoryable()
//	{
//		return $this->morphTo();
//	}
	public function user()
	{
		return $this->belongsTo(User::class,'user_id');
	}

	# Getters
	public function id()
	{
		return $this->category_id;
	}

	public function getLink(){
		return preg_replace("/[\s-]+/", "-", $this->title);
	}

    public function cascade(){
        $children = array();
        $parents = array();

        foreach ($this->children as $parent){
            $parents[] = $parent->category_id;
            $children[] = $parent->category_id;
        }
        while(sizeof($parents) > 0){
            $categories = Category::with('user')->whereIN('parent_id',$parents)->get();

            $parents = array();
            if(!$categories->isEmpty()) {
                foreach ($categories as $category) {
                    $children[] = $category->id();
                    $parents[] = $category->id();
                }
            }
        }
       return Category::whereIN('category_id',$children)->orderBy('parent_id')->get()->toArray();
    }

    public function tree($data, $parent = 0, $depth=0){
        if($depth > 500) return '';
        $tree = '<ul class="list-group">';
        foreach($data as $cat){
            if($cat['parent_id'] == $parent){
                $tree .= '<li class="list-group-item">';
                $tree .= $cat['title'];
                // nog een keer deze functie draaien
                $tree .= $this->tree($data, $cat['category_id'], $depth+1);
                $tree .= '</li>';
            }
            unset($data[$cat['category_id']]);
        }
        $tree .= '</ul>';
        return $tree;
    }
}
