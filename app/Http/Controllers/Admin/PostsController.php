<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Post;
use CMS\UserActions;

class PostsController extends Controller
{
    use UserActions;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $posts = Post::with('category','user')->where('posts.trashed',0)->orderBy('post_id', 'desc')->get();
        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 0]);
    }

    public function deleted(){
        $posts = Post::with('category','user')->where('posts.trashed',1)->orderBy('post_id', 'desc')->get();
        dd($posts);
        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 1]);
    }

    public function add(Request $r)
    {
        $this->validate($r, [
            'title' => 'required|min:4',
            'content' => 'required|min:5',
        ]);
        $post = new Post($r->all());
        $post->user_id = Auth::user()->user_id;
        $post->save();
        return back();
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit')->with(['post' => $post,'template'=>$this->adminTemplate()]);
    }

    public function update(Request $r, Post $post)
    {
        if($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:4',
                'content' => 'required|min:5',
            ]);

            $post->user_id = Auth::user()->user_id;
            $post->update($r->all());
            return back();
        }

    }

    public function action(Request $r)
    {
        $this->Actions($r,'posts');
        return back();
    }
}
