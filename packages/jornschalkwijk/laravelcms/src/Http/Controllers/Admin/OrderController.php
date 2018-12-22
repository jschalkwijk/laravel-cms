<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use JornSchalkwijk\LaravelCMS\Models\Cart;
    use JornSchalkwijk\LaravelCMS\Models\Order;
    use JornSchalkwijk\LaravelCMS\Models\Product;
    use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;

    class OrderController extends Controller
    {
        use ControllerActionsTrait;
        protected $cart;

        public function __construct(Cart $cart)
        {
            $this->cart = $cart;
        }

        public function index(){
            if($this->cart->refresh() || !$this->cart->subTotal()) {
                return back();
            }

            return view('JornSchalkwijk\LaravelCMS::admin.orders.order')->with(['cart' => $this->cart,'template' => $this->adminTemplate()]);
        }

        public function show(Request $r,Order $order)
        {

        }

        public function create(Request $r)
        {
            if($this->cart->refresh()){
                return back();
            }

            //create order
//            $this->validator($r->all())->validate();
            Validator::make(
                $r->all(),
                $rules = [
                    'name'         => [
                        'required', 'alpha', 'max:255',
                    ],
                    'email'        => [
                        'required', 'email', 'max:255',
                        Rule::unique('customers'),
                    ],
                    'password'     => 'required|min:8|alpha_num|confirmed',
                    'address1'     => 'required|min:3|alpha',
                    'address2'     => 'min:3|alpha',
                    'postal'       => 'required|min:3|alpha_num',
                    'city'         => 'required|min:3|alpha',
                    'billing_same' => 'accepted',
                    'billing_address1' => 'required_unless:billing_same,accepted|min:3|alpha',
                    'billing_address2' => 'min:3|alpha',
                    'billing_postal' => 'required_unless:billing_same,accepted|min:3|alpha_num',
                    'billing_city' => 'required_unless:billing_same,accepted|min:3|alpha',
                ]
            )->validate();

            return route('payment.payment');

        }
        public function edit()
        {
        }

        public function store(Request $r)
        {
            if($this->cart->refresh()){
                return back();
            }

            //create order
            $this->validator($r->all())->validate();

            return redirect()->route('payment.index');
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
        public function refresh(Request $r){

            if($r->ajax()){
                $cart = $this->cart;
                $html = view('JornSchalkwijk\LaravelCMS::admin.orders.order-summary')->with(['cart' => $cart])->render();
                $summary = view('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')->with(['cart' => $cart])->render();
                return response()->json(['success' => true,'cart' => $html,'summary' => $summary]);
            } else {
                return back();
            }
        }

        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $data
         * @return \Illuminate\Contracts\Validation\Validator
         */
        protected function validator(array $data,$user_id = 0)
        {
            return Validator::make(
                $data,
                $rules = [
                    'name'         => [
                        'required', 'alpha', 'max:255',
                    ],
                    'email'        => [
                        'required', 'email', 'max:255',
                        Rule::unique('customers'),
                    ],
                    'password'     => 'required|min:8|alpha_num|confirmed',
                    'address1'     => 'required|min:3|alpha',
                    'address2'     => 'min:3|alpha',
                    'postal'       => 'required|min:3|alpha_num',
                    'city'         => 'required|min:3|alpha',
                    'billing_same' => 'accepted',
                'billing_address1' => 'required_unless:billing_same,accepted|min:3|alpha',
                'billing_address2' => 'min:3|alpha',
                'billing_postal' => 'required_unless:billing_same,accepted|min:3|alpha_num',
                'billing_city' => 'required_unless:billing_same,accepted|min:3|alpha',
                ],
                $messages = [
                    'required' => 'The :attribute field is required.',
                ]
            );

        }
        
    }