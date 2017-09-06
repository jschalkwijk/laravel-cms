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

    public function tree($data, $parent = 0){
        $list = [];
        $refs = [];

        foreach ($data as $row)
        {
            $ref = & $refs[$row['category_id']];

            $ref['parent_id'] = $row['parent_id'];
            $ref['title'] = $row['title'];

            if ($row['parent_id'] == $parent)
            {
                $list[$row['category_id']] = & $ref;
            }
            else
            {
                $refs[$row['parent_id']]['children'][$row['category_id']] = & $ref;
            }
        }
        return $this->treeList($list);
    }

    public function treeList(array $array)
    {
        $html = '<ul class="list-group">';

        foreach ($array as $key => $value)
        {
            $html .= '<li class="list-group-item">' . $value['title'];
            if (!empty($value['children']))
            {
                $html .= $this->treelist($value['children']);
            }
            $html .= '</li>';
        }

        $html .= '</ul>' ;

        return $html;
    }

}
