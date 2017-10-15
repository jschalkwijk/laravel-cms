<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Object_;

class Category extends Model
{
    protected $primaryKey = 'category_id';
	protected $fillable = ['title','description','parent_id'];
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

//    public function cascade(){
//        $children = array();
//        $parents = array();
//
//        foreach ($this->children as $parent){
//            $parents[] = $parent->category_id;
//            $children[] = $parent->category_id;
//        }
//        while(sizeof($parents) > 0){
//            $categories = Category::whereIN('parent_id',$parents)->get();
//
//            $parents = array();
//            if(!$categories->isEmpty()) {
//                foreach ($categories as $category) {
//                    $children[] = $category->id();
//                    $parents[] = $category->id();
//                }
//            }
//        }
//       return Category::with('children')->whereIN('category_id',$children)->orderBy('parent_id')->get();
//    }

//    public function tree($data, $parent = 0){
//        $list = [];
//        $refs = [];
//
//        foreach ($data as $row)
//        {
//            $ref = & $refs[$row['category_id']];
//
//            $ref['parent_id'] = $row['parent_id'];
//            $ref['title'] = $row['title'];
//
//            if ($row['parent_id'] == $parent)
//            {
//                $list[$row['category_id']] = & $ref;
//            }
//            else
//            {
//                $refs[$row['parent_id']]['children'][$row['category_id']] = & $ref;
//            }
//        }
//        return $this->treeList($list);
//    }

    /**
     * @param $array
     * @return string
     *
     * Takes an array with the first chidren of the Object, then if those children have children
     * it wil cascade over them en create a list output.
     */
    public function tree($array)
    {

        $html = '<ul class="tree">';

        foreach ($array as $key => $value)
        {
            $html .= '<li><a href="/admin/'.$value->table.'/'.$value->id().'">'.$value->title .'</a>';
            if (!empty($value->children))
            {
                $html .= $this->tree($value->children);
            }
            $html .= '</li>';
        }

        $html .= '</ul>' ;

        return $html;
    }

}
