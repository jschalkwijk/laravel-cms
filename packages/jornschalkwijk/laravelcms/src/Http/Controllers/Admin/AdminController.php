<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;


use JornSchalkwijk\LaravelCMS\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        $posts = Post::with('category','user')->where('posts.trashed',0)->orderBy('post_id','desc')->get();
        return view('JornSchalkwijk\LaravelCMS::admin.admin')->with(['template' => $this->adminTemplate(),'posts' => $posts,'trashed' => 0]);
    }
}
