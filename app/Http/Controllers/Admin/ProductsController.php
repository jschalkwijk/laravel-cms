<?php

namespace CMS\Http\Controllers\admin;

use CMS\Models\Category;
use CMS\Models\Product;
use CMS\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
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
            return back();
        }
    }

    public function edit(Product $product)
    {

        $categories = Category::where('type','product')->get();
        foreach($product->categories as $cat){
            $selectedCat[] = $cat->category_id;
        };
        return view('admin.products.edit')->with(['product' => $product,'categories' => $categories,'selectedCat' => $selectedCat,'template'=>$this->adminTemplate()]);
    }

    public function action()
    {

    }
}
