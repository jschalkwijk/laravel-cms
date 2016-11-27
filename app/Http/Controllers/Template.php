<?php

namespace CMS\Http\Controllers;

class Template {
	
	public $template;
	
	public function template() {
		$this->template = "templates/default";
		return $this->template;
	}
	
}