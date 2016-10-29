<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;

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
