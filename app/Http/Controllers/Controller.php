<?php

namespace CMS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use JornSchalkwijk\LaravelCMS\Models\Cart;
use JornSchalkwijk\LaravelCMS\Models\Support\SessionStorage;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $cart;
	protected $template;
	protected $adminTemplate;
//	protected $currentUser;
//
//	public function __construct()
//	{
//		$this->currentUser = Auth::user();
//	}
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            $this->cart = new Cart(new SessionStorage($request));
            View::share('cart', $this->cart);
            return $next($request);
        });
    }

	protected function template() {
		$this->template = "templates/default";
		return $this->template;
	}
    protected function adminTemplate() {
		$this->template = "JornSchalkwijk\LaravelCMS::admin.templates.default";
		return $this->template;
	}
}
