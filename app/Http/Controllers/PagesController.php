<?php

namespace CMS\Http\Controllers;

use CMS\Models\Page;

class PagesController extends Controller
{
    public function show(Page $page)
    {
        return view('templates.default.page')->with(['page' => $page,'template'=>$this->template()]);
    }
    public function index(){
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
