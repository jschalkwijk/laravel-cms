<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use JornSchalkwijk\LaravelCMS\Models\Cart;
    use JornSchalkwijk\LaravelCMS\Models\Order;
    use JornSchalkwijk\LaravelCMS\Models\Product;
    use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;

    class OrderController extends Controller
    {
        use ControllerActionsTrait;

        public function __construct(Cart $cart,Product $product)
        {
            $this->cart = $cart;
            $this->product = $product;
        }

        public function index(Request $r){

            $this->cart->refresh();
            if(!$this->cart->subTotal()) {
                return back();
            }

            return view('JornSchalkwijk\LaravelCMS::admin.orders.order')->with(['cart' => $this->cart,'template' => $this->adminTemplate()]);
        }

        public function show(Request $r,Order $order)
        {

        }

        public function create()
        {
            
        }
        public function edit()
        {
            
        }

        public function store()
        {

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
        
    }