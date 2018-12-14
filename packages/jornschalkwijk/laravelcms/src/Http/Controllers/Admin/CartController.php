<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use JornSchalkwijk\LaravelCMS\Exeptions\Cart\QuantityExceededException;
use JornSchalkwijk\LaravelCMS\Models\Cart;
use JornSchalkwijk\LaravelCMS\Models\Product;

class CartController extends Controller
{
    protected $cart;
    protected $product;

    public function __construct(Cart $cart,Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
//        $this->basket = new Basket($this->cart);
        // immediatly run the basket->all() method so that every page from this controller has
        // instant access to this basket class.
        // if not instantiated here,you have to call the basket all method in the methods of this cntroller to get access, otherwise
        // the basket class is not.
//        $this->basket->all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
//        print_r($this->cart->all());
//        print_r($r->session()->get('default'));
        return view('JornSchalkwijk\LaravelCMS::admin.cart.cart')->with(['cart'=> $this->cart,'template' => $this->adminTemplate()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $r)
    {
        $product = Product::findOrFail($r->product_id);
        try {
            $this->cart->add($product, $r->quantity);
        } catch (QuantityExceededException $e) {
           // add to flash messages anf return to page
            echo $e->getMessage();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        $product = Product::findOrFail($r->product_id);
        try {
            $this->cart->update($product, $r->quantity);
        } catch (QuantityExceededException $e) {
            $message = $e->getMessage();
        }
        if($r->ajax()){
            $cart = $this->cart;
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.product-row')->with(['cart' => $cart])->renderSections()['content'];
            return response()->json(['success' => true,'product_id' => $product->product_id,'html' => $html]);

//            $cart = $this->cart->all();
//            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.product-row')->with(['cart' => $cart])->renderSections()['content'];
//            return response()->json(['success' => true,'html' => $html]);
        }
        else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        try {
            $this->cart->remove($product);
        } catch (QuantityExceededException $e) {
            echo $e->getMessage();
        }
        return back();
    }

    public function empty()
    {
        $this->cart->clear();
    }
}
