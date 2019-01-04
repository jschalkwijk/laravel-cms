<?php

namespace CMS\Http\Controllers;

use JornSchalkwijk\LaravelCMS\Models\Post;

class Posts extends Controller
{


    public function index()
    {
        $posts = Post::all()->take(10);
        return view('vendor.jornschalkwijk.laravelcms.templates.shop.blog')->with(['posts' => $posts]);
    }
    public function show(Post $post){
			return view('vendor.jornschalkwijk.laravelcms.templates.shop.single-blog')->with(['post'=>$post]);
	}
}
