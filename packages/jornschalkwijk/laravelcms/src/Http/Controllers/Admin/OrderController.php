<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use JornSchalkwijk\LaravelCMS\Models\Cart;
    use JornSchalkwijk\LaravelCMS\Models\Order;
    use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
    use Illuminate\Support\Facades\Validator;

    class OrderController extends Controller
    {
        use ControllerActionsTrait;
        
        public function index(Cart $cart){
            if($cart->refresh() || !$cart->subTotal()) {
                return back();
            }
            $customer = auth()->guard('customer')->user();
            if(!empty($customer)){
                $addresses =  $customer->addresses()->withPivot('primary')->get();
                return view('JornSchalkwijk\LaravelCMS::admin.orders.order')->with(['cart' => $cart,'customer'=> $customer,'addresses'=> $addresses,'template' => $this->adminTemplate()]);
            } else {
                return view('JornSchalkwijk\LaravelCMS::admin.orders.order')->with(['cart' => $cart,'customer'=> $customer,'template' => $this->adminTemplate()]);
            }
        }

        public function show(Order $order)
        {
            return view('JornSchalkwijk\LaravelCMS::admin.orders.show')->with(['order' => $order,'template' => $this->adminTemplate()]);
        }

        public function create(Request $r,Cart $cart)
        {
            if($cart->refresh()){
                return back();
            }

            //create order
//            $this->validator($r->all())->validate();


            return route('payment.payment');

        }
        public function edit()
        {
        }

        public function store(Request $r,Cart $cart)
        {
            if($cart->refresh() || (empty($customer = Auth::guard('customer')->user()))){
                return back();
            }
//            print_r($r->all());
//            die('hello');
            $this->validator($r->all())->validate();


            // Create Order
            $order = new Order();
            $order->hash = bin2hex(random_bytes(32));
            $order->total = $cart->total();
            $order->paid =  false;
            $order->customer_id = $customer->customer_id;
            $order->address_id = $r->shipping_address;
            $order->billing_address_id = !$r->billing_same ? $r->billing_address : $order->address_id;

            $order->save();

            // Add products to orders_products pivot table and update stock value
            $products = [];
            foreach ($cart->all() as $product) {
                $products[$product->product_id] = ['quantity' => $product->getQuantity()];
                $product->decrement('stock', $product->getQuantity());
            }

            $order->products()->attach($products);
            // empty cart
            $cart->clear();

            return redirect()->route('order.show',[$order->hash]);
        }
        public function update()
        {
            
        }

        public function paid()
        {
            
        }

        public function cancelled()
        {
            
        }
        public function refresh(Request $r,Cart $cart){

            if($r->ajax()){
                $html = view('JornSchalkwijk\LaravelCMS::admin.orders.order-summary')->with(['cart' => $cart])->render();
                $summary = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')->with(['cart' => $cart])->render();
                return response()->json(['success' => true,'cart' => $html,'summary' => $summary]);
            } else {
                return back();
            }
        }

        /**
         * @param array $data
         */
        public function validator(Array $data)
        {
            return Validator::make(
                $data,
                $rules = [
                    'shipping_address' => 'required',
                    'billing_address' => 'required_without:billing_same',
                    'confirm' => 'required',
                ]
            );
        }

        /**
         * Get the guard to be used during registration.
         *
         * @return \Illuminate\Contracts\Auth\StatefulGuard
         */
        protected function guard()
        {
            return Auth::guard();
        }
        
    }