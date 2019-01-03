<?php

namespace CMS\Http\Controllers;

class Posts extends Controller
{


    public function index()
    {
        return view('vendor.jornschalkwijk.laravelcms.templates.shop.blog');
    }
    public function show(Post $post){
			return view('posts.show')->with(['template'=>$this->template(),'post'=>$post]);
	}
}
