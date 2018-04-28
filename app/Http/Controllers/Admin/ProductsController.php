<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Category;
use CMS\Models\Product;
use CMS\Models\Tag;
use CMS\Http\Controllers\Controller;
use CMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Product::class;

    public function index()
    {
        $products = Product::with('category')->where('trashed',0)->orderBy('product_id','desc')->get();
        return view('admin.products.products')->with(['template'=>$this->adminTemplate(),'products'=>$products,'trashed' => 0]);
    }

    public function deleted()
    {
        $products = Product::with('category')->where('trashed',1)->orderBy('product_id','desc')->get();
        return view('admin.products.products')->with(['template'=>$this->adminTemplate(),'products'=>$products,'trashed' => 1]);
    }


    public function create()
    {
        // Get all the categories associated with Product
        $categories = Category::where('type','product')->get();
        $tags = Tag::where('type','product')->get();
        return view('admin.products.create')->with(['categories' => $categories,'tags' => $tags,'template'=>$this->adminTemplate()]);
}

    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|min:4',
            'description' => 'required|min:5',
            'price' => 'required|numeric|min:1|',
            'quantity' => 'required|numeric|min:1|',
        ]);
        $product = new Product($r->all());
//        $product->user_id = Auth::user()->user_id;
        $product->save();


        if(!empty($r['category'])){
            $category = new Category();
            $category->title = $r['category'];
            $category->type = $r['cat_type'];
            $category->user_id = Auth::user()->user_id;
            $category->save();
            $lastInsertID = $category->category_id;
            $category_ids[] = $lastInsertID;
        }

        $tag_ids = $r['tag_ids'];

        if(!empty($r['tag'])){
            $multiple = explode('|',$r['tag']);
            foreach($multiple as $tagName) {
                $tag = new Tag();
                $tag->title = $tagName;
                $tag->type = $r['tag_type'];
                $tag->user_id = Auth::user()->user_id;
                $tag->save();
                $lastInsertID = $tag->tag_id;
                $tag_ids[] = $lastInsertID;
            }
        }
        // Save selected categories, if all are deselected , detach all relations else sync selected
        (!is_array($tag_ids)) ? $product->tags()->detach() : $product->tags()->sync($tag_ids);

        return redirect()->action('Admin\ProductsController@index');
    }

    public function update(Request $r,Product $product)
    {
        if($r['confirm']) {
            $this->validate($r, [
                'name'        => 'required|min:4',
                'description' => 'required|min:5',
                'price'       => 'required|numeric|min:1|',
                'quantity'    => 'required|numeric|min:1|',
            ]);
            $product->update($r->all());

            if(!empty($r['category'])){
                $category = new Category();
                $category->title = $r['category'];
                $category->type = $r['cat_type'];
                $category->user_id = Auth::user()->user_id;
                $category->save();
                $lastInsertID = $category->category_id;
                $category_ids[] = $lastInsertID;
            }

            $tag_ids = $r['tag_ids'];

            if(!empty($r['tag'])){
                $multiple = explode('|',$r['tag']);
                foreach($multiple as $tagName) {
                    $tag = new Tag();
                    $tag->title = trim($tagName);
                    $tag->type = $r['tag_type'];
                    $tag->user_id = Auth::user()->user_id;
                    $tag->save();
                    $lastInsertID = $tag->tag_id;
                    $tag_ids[] = $lastInsertID;
                }
            }

            // Save selected tags, if all are deselected , detach all relations else sync selected
            (!is_array($tag_ids)) ? $product->tags()->detach() : $product->tags()->sync($tag_ids);

            return back();
        }
    }

    public function edit(Product $product)
    {
        // Get all the categories associated with Product
        $categories = Category::where('type','product')->get();
        $tags = Tag::where('type','product')->get();
        $selectedTag = [];
        foreach ($product->tags as $tag) {
            $selectedTag[] = $tag->tag_id;
        };
        return view('admin.products.edit')->with(['product' => $product,'categories' => $categories,'tags' => $tags, 'selectedTag' => $selectedTag,'template'=>$this->adminTemplate()]);
    }
}
