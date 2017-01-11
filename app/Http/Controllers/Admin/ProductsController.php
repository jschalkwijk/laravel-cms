<?php

namespace CMS\Http\Controllers\admin;

use CMS\Models\Category;
use CMS\Models\Product;
use CMS\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->where('trashed',0)->orderBy('product_id','desc')->get();
        return view('admin.products.products')->with(['template'=>$this->adminTemplate(),'products'=>$products,'trashed' => 0]);
    }

    public function deleted()
    {
        $products = Product::with('categories')->where('trashed',1)->orderBy('product_id','desc')->get();
        return view('admin.products.products')->with(['template'=>$this->adminTemplate(),'products'=>$products,'trashed' => 1]);
    }


    public function create()
    {
        // Get all the categories associated with Product
        $categories = Category::where('type','product')->get();
        return view('admin.products.create')->with(['categories' => $categories,'template'=>$this->adminTemplate()]);
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

        $category_ids = $r['category_ids'];

        if(!empty($r['category'])){
            $category = new Category();
            $category->title = $r['category'];
            $category->type = $r['cat_type'];
            $category->user_id = Auth::user()->user_id;
            $category->save();
            $lastInsertID = $category->category_id;
            $category_ids[] = $lastInsertID;
        }
        // Save selected categories
        $product->categories()->sync($category_ids);
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

            $category_ids = $r['category_ids'];

            if(!empty($r['category'])){
                $category = new Category();
                $category->title = $r['category'];
                $category->type = $r['cat_type'];
                $category->user_id = Auth::user()->user_id;
                $category->save();
                $lastInsertID = $category->category_id;
                $category_ids[] = $lastInsertID;
            }
            // Save selected categories, if all are deselected , detach all relations else sync selected
            (!is_array($category_ids)) ? $product->categories()->detach() : $product->categories()->sync($category_ids);
            return back();
        }
    }

    public function edit(Product $product)
    {
        // Get all the categories associated with Product
        $categories = Category::where('type','product')->get();
        $selectedCat = [];
        foreach($product->categories as $cat){
            $selectedCat[] = $cat->category_id;
        };
        return view('admin.products.edit')->with(['product' => $product,'categories' => $categories,'selectedCat' => $selectedCat,'template'=>$this->adminTemplate()]);
    }

    public function action()
    {

    }
}
