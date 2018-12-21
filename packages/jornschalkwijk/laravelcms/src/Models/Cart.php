<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Support\Facades\Session;
use JornSchalkwijk\LaravelCMS\Models\Support\StorageInterface;
use JornSchalkwijk\LaravelCMS\Exeptions\Cart\QuantityExceededException;
class Cart
{
    protected $storage;
    protected $product;
    public $subTotal = 0;
    public $totalTax;
    public $totalQuantity;
    public $shipping = 5;
    public function __construct(StorageInterface $storage,Product $product)
    {
        $this->storage = $storage;
        $this->product = $product;
    }

    public function add(Product $product, $quantity)
    {
//        $product = Product::findOrFail($product);
        // Takes a product class which holds all the information.
        $this->product = $product;
        // Check if the product is already in the basket.
        if($this->has($product)){
            // If we already have the product in the basket
            // We get the product by the ID and set the quantity to current quantity + new quantity
            $quantity = $this->get($product)['quantity'] + $quantity;
        }
        // update session with product and quantity
        $this->update($product,$quantity);
    }

    public function update(Product $product, $quantity)
    {
        // Check is the Product has enough stock for the desired amount given by user
        if(!$product->hasStock($quantity)) {

            throw new QuantityExceededException;
        }
        // if the quantity is set to 0 remove the product from the basket session
        if ((int)$quantity === 0) {
            $this->remove($product);
            return;
        }
        // set basket session to desired quantity $_SESSION['default']['10',[ 'product_id' => 10, 'quantity' => 3,]]
        $this->storage->set($product->product_id,[
            'product_id' => (int) $product->product_id,
            'quantity' => (int) $quantity,
        ]);
    }

    public function remove(Product $product)
    {
        // remove item from the basket session
        $this->storage->unsetIndex($product->product_id);
    }

    public function has(Product $product)
    {
        // Check if the product is already in the basket.
        return $this->storage->exists($product->product_id);
    }

    public function get(Product $product)
    {
        // get a product from the basket session by ID
        return $this->storage->get($product->product_id);
    }

    public function clear() {
        // Removes the entire basket session
        $this->storage->clear();
    }

    public function all(){

        $ids = [];
        $items = [];
        $subTotal = 0;
        $countAll = 0;
        $this->totalTax = 0;
        if(!empty($this->storage->all())) {
            foreach ($this->storage->all() as $product) {
                $ids[] = $product['product_id'];
            }

//            print_r($ids);
//            die('dsfafasd');
            $products = Product::find($ids);

            foreach ($products as $product) {
                // The current stock is the max stock, this is not the quantity that a user wants to order perse,
                // Will be used inside cart view for selecting only the maximum available items;
                $product->setMaxStock($product->getQuantity());
                // if the product still has enough stock we set the quantity to order
                // to the desired amount. If a other user checked out when you are shopping
                // the stock changes. if the product stock is lower then the desired amount added
                // earlier the quantity changed to the maximum available current stock.
                // because we don't change the original qty of the fetched product it will be displayed
                // with the current stock on the cart page view.
                // ex. I added a product with a quantity of 5. when I return to the cart, a other user
                // has checked out 2. Then the basket will display 3, because that is max amount available.
                if($product->hasStock($this->get($product)['quantity'])){
                    // is we have enough stock, we change the product objects qty to the desired qty.
                    $product->setQuantity($this->get($product)['quantity']);
                } else {
                    $this->update($product,$product->stock);
                    $product->setQuantity($product->stock);
                    Session::flash($product->product_id, 'The quantity of '.$product->name .' had been decreased because someone else placed an order');
                }

                $items[] = $product;

                $subTotal = $subTotal + ($product->total() * $product->getQuantity());

                $countAll = $countAll + $product->getQuantity();

                $productsTax = $product->tax_value * $product->getQuantity();

                $this->totalTax = $productsTax + $this->totalTax;
            }
            $this->subTotal = $subTotal;
            $this->totalQuantity = $countAll;

        }

        return $items;

    }

    public function refresh()
    {
       $this->all();
    }

    public function itemCount(){
        return $this->storage->count();
    }

    public function subTotal(){

        return $this->subTotal;
    }
    public function total(){

        return $this->subTotal()+$this->shipping;
    }

    public function totalQuantity(){
        return $this->totalQuantity;
    }
}
