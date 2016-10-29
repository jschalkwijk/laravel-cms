<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Template;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $template;
	protected $adminTemplate;
	protected function template() {
		$this->template = "templates/default";
		return $this->template;
	}
    protected function adminTemplate() {
		$this->template = "admin/templates/default";
		return $this->template;
	}
}
