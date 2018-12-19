<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Models\Category;
use JornSchalkwijk\LaravelCMS\Models\Folder;
use JornSchalkwijk\LaravelCMS\Models\Gallery;
use JornSchalkwijk\LaravelCMS\Models\Product;
use JornSchalkwijk\LaravelCMS\Models\Tag;
use JornSchalkwijk\LaravelCMS\Models\Cart;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Product::class;
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $products = Product::with('category')->where('trashed',0)->orderBy('product_id','desc')->get();
        return view('JornSchalkwijk\LaravelCMS::admin.products.products')->with(['template'=>$this->adminTemplate(),'products'=>$products,'trashed' => 0]);
    }

    public function show(Product $product)
    {
        // calc quantity left when user already has added the item to its cart before so he cant exceed the amount in stock.
        $cart_quantity = $this->cart->get($product)['quantity'];
        $quantity_left = $product->stock - $cart_quantity;
        return view('JornSchalkwijk\LaravelCMS::admin.products.show')->with(['quantity_left'=>$quantity_left,'template'=>$this->adminTemplate(),'product'=>$product]);
    }

    public function deleted()
    {
        $products = Product::with('category')->where('trashed',1)->orderBy('product_id','desc')->get();
        return view('JornSchalkwijk\LaravelCMS::admin.products.products')->with(['template'=>$this->adminTemplate(),'products'=>$products,'trashed' => 1]);
    }


    public function create()
    {
        // Get all the categories associated with Product
        $categories = Category::where('type','product')->get();
        $tags = Tag::where('type','product')->get();
        $galleries = Gallery::all();
        $folders = Folder::where('parent_id', 0)->get();
        return view('JornSchalkwijk\LaravelCMS::admin.products.create')->with(['categories' => $categories, 'tags' => $tags, 'galleries' => $galleries,'folders' => $folders,'template' => $this->adminTemplate()]);
}

    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|min:4',
            'price' => 'required|numeric|min:1|',
            'description' => 'required|min:5',
            'quantity' => 'required|numeric|min:1',
            'tax_percentage' => 'required|numeric|min:1',
            'discount_percentage' => 'required|numeric|min:0',
        ]);

        // Set values and calculate Discount and Tax Value
        $product = new Product($r->all());
        $product->user_id = Auth::user()->user_id;
        $product->setDiscount();
        $product->setTaxValue();

        // Create Folder
        $folder = new Folder();
        $folder->name = $product->name;
        $folder->user_id = Auth::user()->user_id;
        $folder->parent_id = 9;

        $folder->save();

        // Set folder_id after creation
        $product->folder_id = $folder->folder_id;

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

        return redirect()->action('\JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@index');
    }

    public function edit(Product $product)
    {
        // Get all the categories associated with Product
        $categories = Category::where('type', 'product')->get();
        $tags = Tag::where('type', 'product')->get();
        $selectedTags = [];
        foreach ($product->tags as $tag) {
            $selectedTag[] = $tag->tag_id;
        };
        $galleries = Gallery::all();
        $folders = Folder::where('parent_id', 0)->get();

        return view('JornSchalkwijk\LaravelCMS::admin.products.edit')->with(['product' => $product, 'categories' => $categories, 'tags' => $tags, 'selectedTags' => $selectedTags, 'galleries' => $galleries,'folders' => $folders,'template' => $this->adminTemplate()]);
    }

    public function update(Request $r,Product $product)
    {
        if($r['confirm']) {
            $this->validate($r, [
                'name' => 'required|min:4',
                'price' => 'required|numeric|min:1|',
                'description' => 'required|min:5',
                'quantity' => 'required|numeric|min:1',
                'tax_percentage' => 'required|numeric|min:1',
                'discount_percentage' => 'required|numeric|min:0',
            ]);
            // Set values and calculate Discount and Tax Value
            $product->update($r->all());
            $product->user_id = Auth::user()->user_id;
            $product->setDiscount();
            $product->setTaxValue();

            // Create Folder
            if(!Folder::findOrFail($product->folder_id)) {
                $folder = new Folder();
                $folder->name = $product->name;
                $folder->user_id = Auth::user()->user_id;
                $folder->parent_id = 9;

                $folder->save();
                // Set folder_id after creation
                $product->folder_id = $folder->folder_id;
            }

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
        }
        return back();
    }
}
