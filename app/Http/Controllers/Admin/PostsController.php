<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Models\Post;
use CMS\Models\Category;
use CMS\Models\UserActions;

class PostsController extends Controller
{
    use UserActions;

    public function index(){
        $posts = Post::with('category','user')->where('posts.trashed',0)->orderBy('post_id','desc')->get();
        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 0]);
    }

    public function deleted(){
        $posts = Post::with('category','user')->where('posts.trashed',1)->orderBy('post_id','desc')->get();

        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 1]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create')->with(['categories' => $categories,'template'=>$this->adminTemplate()]);
    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'title' => 'required|min:4',
            'content' => 'required|min:5',
        ]);
        $post = new Post($r->all());
        $post->user_id = Auth::user()->user_id;
        $post->save();
        return redirect()->action('Admin\PostsController@index');
    }

    public function edit(Post $post)
    {
        $post->load('category.user');
        $categories = Category::all();
        return view('admin.posts.edit')->with(['post' => $post,'categories' => $categories,'template'=>$this->adminTemplate()]);
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
