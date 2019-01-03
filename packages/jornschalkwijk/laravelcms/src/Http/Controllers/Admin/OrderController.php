<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerRegisterController;
    use JornSchalkwijk\LaravelCMS\Models\Address;
    use JornSchalkwijk\LaravelCMS\Models\Cart;
    use JornSchalkwijk\LaravelCMS\Models\Customer;
    use JornSchalkwijk\LaravelCMS\Models\Order;
    use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;
    use Illuminate\Auth\Events\Registered;

    class OrderController extends Controller
    {
        use ControllerActionsTrait;
        
        public function index(Cart $cart){
            if($cart->refresh() || !$cart->subTotal()) {
                return back();
            }

            return view('JornSchalkwijk\LaravelCMS::admin.orders.order')->with(['cart' => $cart,'template' => $this->adminTemplate()]);
        }

        public function confirm(){

            $customer = auth()->guard('customer')->user();

            return view('JornSchalkwijk\LaravelCMS::admin.orders.confirm')->with(['customer' => $customer,'template' => $this->adminTemplate()]);
        }


        public function payment($hash){

            $order = Order::with('products')->where('hash',$hash)->first();

            return view('JornSchalkwijk\LaravelCMS::admin.orders.payment')->with(['order' => $order,'template' => $this->adminTemplate()]);
        }

        public function show(Request $r,Order $order)
        {

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
            if($cart->refresh()){
                return back();
            }
            $customer = Auth::guard('customer')->user();
//            $this->validator($r->all())->validate();
//
//            // remove product stock
//
//            $address = Address::where([['address_1', '=', $r->address_1],['address_2', '=', $r->address_2],['postal', '=', $r->postal]])->first();
//            if ($address === null) {
//                // Create Address
//                $address = new Address();
//                $address->address_1 = $r->address_1;
//                $address->address_2 = $r->address_2;
//                $address->postal = $r->postal;
//                $address->city = $r->city;
//
//                $address->save();
//            }
//
//            // Create Customer
//
//            $customer = new Customer();
//            $customer->first_name = $r->first_name;
//            $customer->last_name = $r->last_name;
//            $customer->email = $r->email;
//            $customer->password = bcrypt($r->password);
//            $customer->phone_1 = $r->phone_1;
//            $customer->phone_2 = $r->phone_2;
//            $customer->dob = $r->dob;
//
//            $customer->save();
//            $customer->addresses()->attach($address->address_id);
//
//            event(new Registered($customer));
//
//            Auth::guard('customer')->login($customer);
            // After saving update the customer and address tables with the saved id


            // Create Order
            $order = new Order();
            $order->hash = bin2hex(random_bytes(32));
            $order->total = $cart->total();
            $order->paid =  false;
            $order->customer_id = $customer->customer_id;
            $order->address_id = $customer->addresses()->wherePivot('type','=','primary')->address_id;

            // Create Billing address
            if (!$r->billing_same){
                $billing_address = Address::where(
                    [
                        ['address_1', '=', $r->billing_address_1],
                        ['address_2', '=', $r->billing_address_2],
                        ['postal', '=', $r->billing_postal],
                        ['city', '=', $r->billing_city],
                    ]
                )->first();
                if($billing_address === null) {
                    $billing_address = new Address();
                    $billing_address->address_1 = $r->billing_address_1;
                    $billing_address->address_2 = $r->billing_address_2;
                    $billing_address->postal = $r->billing_postal;
                    $billing_address->city = $r->billing_city;
                    $billing_address->save();
                }
                // Set order billing address
                $order->billing_address_id = $billing_address->address_id;
                $billing_address->customers()->attach($customer->customer_id);
            } else {
                // if address is the same set the shipping address as billing
                $order->billing_address_id = $order->address_id;
            }

            $order->save();

            // Add products to orders_products pivot table
            $products = [];
            foreach ($cart->all() as $product) {
                $products[$product->product_id] = ['quantity' => $product->getQuantity()];
            }

            $order->products()->attach($products);

            // empty cart
            $cart->clear();

            return redirect()->route('order.payment',[$order->hash]);
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
                    'first_name'         => [
                        'required', 'regex:/^[\pL\s\-]+$/u', 'max:255',
                    ],
                    'last_name'         => [
                        'required', 'regex:/^[\pL\s\-]+$/u', 'max:255',
                    ],
                    'email'        => [
                        'required', 'email', 'max:255',
                        Rule::unique('customers'),
                    ],
                    'password'     => 'min:8|alpha_num|confirmed',
                    'address_1'     => 'required|min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                    'address_2'     => 'min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                    'postal'       => 'required|min:3|alpha_num',
                    'city'         => 'required|min:3|alpha',
                    'billing_address_1' => 'required_without:billing_same|min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                    'billing_address_2' => 'min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                    'billing_postal' => 'required_without:billing_same|min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                    'billing_city' => 'required_without:billing_same|min:3|alpha',
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