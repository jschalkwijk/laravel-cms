<?php

namespace App\Http\Controllers;
use App\Post;

class Posts extends Controller
{
    public function index(){
		$posts = Post::all()->load('category');
		return view('posts.index')->with(['template'=>$this->template(),'posts'=>$posts]);
	}
	
	 public function show(Post $post){
			return view('posts.show')->with(['template'=>$this->template(),'post'=>$post]);
	}
}
