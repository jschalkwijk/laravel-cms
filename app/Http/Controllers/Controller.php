<?php

namespace CMS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

use CMS\Template;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $template;
	protected $adminTemplate;
//	protected $currentUser;
//
//	public function __construct()
//	{
//		$this->currentUser = Auth::user();
//	}

	protected function template() {
		$this->template = "templates/default";
		return $this->template;
	}
    protected function adminTemplate() {
		$this->template = "JornSchalkwijk\LaravelCMS::admin.templates.default";
		return $this->template;
	}
}
