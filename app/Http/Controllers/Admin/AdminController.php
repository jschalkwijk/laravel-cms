<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Http\Controllers\Controller;
use CMS\Models\Post;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $posts = Post::with('category','user')->where('posts.trashed',0)->orderBy('post_id','desc')->get();
        return view('admin.admin')->with(['template' => $this->adminTemplate(),'posts' => $posts,'trashed' => 0]);
    }
}
