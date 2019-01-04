<?php

namespace CMS\Http\Controllers;

use Illuminate\Http\Request;
use JornSchalkwijk\LaravelCMS\Models\Category;
use JornSchalkwijk\LaravelCMS\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->where([['type','=','product'],['parent_id','=', 0]])->get();
        $products = Product::all();
        return view('vendor.jornschalkwijk.laravelcms.templates.shop.shop.shop')->with(['products' => $products,'categories' => $categories]);
    }
}
