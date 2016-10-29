<?php

namespace App\Http\Controllers;

class Pages extends Controller
{
    public function home(){
        return view('pages.home')->with(['template'=>$this->template()]);
	}
	
	public function about(){
		return view('pages.about')->with(['template'=>$this->template()]);
	}

    public function skills()
    {
        return view('pages.skills')->with(['template' => $this->template()]);
    }
}
