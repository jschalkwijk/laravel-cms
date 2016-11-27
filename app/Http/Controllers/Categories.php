<?php

namespace CMS\Http\Controllers;

use Illuminate\Http\Request;

use CMS\Http\Requests;

use CMS\Category;

class Categories extends Controller
{
      public function index(){
			$categories = Category::all();
			return view('categories.index')->with(['template'=>$this->template(),'categories'=>$categories]);
	}
	
	/*public function show($card){
			$card = Card::find($card);
			return $card;
			return view('cards.show')->with(['template'=>$this->template(),'card'=>$card]);
	}*/
	
	public function show(Category $category){
			return view('categories.show')->with(['template'=>$this->template(),'category'=>$category]);
	}
}
