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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
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
            return response()->json(['success' => false,$message]);
        }
        if($r->ajax()){
            $cart = $this->cart;
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
            return response()->json(['success' => true,'html' => $html]);
        }
        else {
            return back();
        }
    }
     public function refresh(Request $r){

         if($r->ajax()){
             $cart = $this->cart;
             $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
             return response()->json(['success' => true,'html' => $html]);
         } else {
             return back();
         }
     }
    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $r
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $r,$id)
    {
        $product = Product::findOrFail($id);
        try {
            $this->cart->remove($product);
        } catch (QuantityExceededException $e) {
            $message = $e->getMessage();
            return response()->json(['success' => false,$message]);
        }
        if($r->ajax()){
            $cart = $this->cart;
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
            return response()->json(['success' => true,'html' => $html]);
        } else {
            return back();
        }
    }

    public function empty(Request $r)
    {
        $this->cart->clear();
        if($r->ajax()){
            $cart = $this->cart;
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
            return response()->json(['success' => true,'html' => $html]);
        } else {
            return back();
        }
    }
}
