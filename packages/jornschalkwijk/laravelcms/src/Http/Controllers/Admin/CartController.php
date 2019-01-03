<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use JornSchalkwijk\LaravelCMS\Exeptions\Cart\QuantityExceededException;
use JornSchalkwijk\LaravelCMS\Models\Cart;
use JornSchalkwijk\LaravelCMS\Models\Product;
use JornSchalkwijk\LaravelCMS\Models\Support\SessionStorage;

class CartController extends Controller
{
    protected $cart;
    protected $product;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->cart = new Cart(new SessionStorage($request));
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cart $cart,Request $r)
    {
//        print_r($this->cart->all());
//        die('hello');
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
//            print_r($cart->all());
//            die('hello');
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
    public function update(Cart $cart,Request $r)
    {
        $product = Product::findOrFail($r->product_id);
        try {
            $cart->update($product, $r->quantity);
        } catch (QuantityExceededException $e) {
            $message = $e->getMessage();
            return response()->json(['success' => false,$message]);
        }
        if($r->ajax()){
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
            return response()->json(['success' => true,'html' => $html]);
        }
        else {
            return back();
        }
    }
    public function refresh(Cart $cart,Request $r){

        if($r->ajax()){
            $html = '';
            $summary = '';
            if (count($cart->all()) != 0) {
                $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
                $summary = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')->with(['cart' => $cart])->render();
            }
            return response()->json(['success' => true,'cart' => $html,'summary' => $summary]);
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
    public function destroy(Cart $cart,Request $r,$id)
    {
        $product = Product::findOrFail($id);
        try {
            $cart->remove($product);
        } catch (QuantityExceededException $e) {
            $message = $e->getMessage();
            return response()->json(['success' => false,$message]);
        }
        if($r->ajax()){
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
            return response()->json(['success' => true,'html' => $html]);
        } else {
            return back();
        }
    }

    public function empty(Cart $cart,Request $r)
    {
        $cart->clear();
        if($r->ajax()){
            $html = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')->with(['cart' => $cart])->render();
            return response()->json(['success' => true,'html' => $html]);
        } else {
            return back();
        }
    }
}
