<?php

namespace App\Http\Controllers;

use App\Card;

class Cards extends Controller{
    public function index(){
			$cards = Card::all();
			return view('cards.index')->with(['template'=>$this->template(),'cards'=>$cards]);
	}
	public function show(Card $card){
            // eager loading means that we only fetch the relationships and dont perform
            // multiple queries in the for loop on the blade file.
            $card->load('notes.user');
			return view('cards.show')->with(['template'=>$this->template(),'card'=>$card]);
	}

}
