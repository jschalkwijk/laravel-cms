<?php

namespace CMS\Http\Controllers;
use CMS\Post;

class Posts extends Controller
{

	 public function show(Post $post){
			return view('posts.show')->with(['template'=>$this->template(),'post'=>$post]);
	}
}
