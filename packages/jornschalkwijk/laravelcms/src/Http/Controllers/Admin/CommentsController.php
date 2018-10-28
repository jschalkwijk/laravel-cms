<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Models\Comment;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Comment::class;

    public function index()
    {
        $comments = Comment::with('user')->where('trashed',0)->orderBy('comment_id','desc')->get();
        return view('admin.comments.comments')->with(['template'=>$this->adminTemplate(),'comments' => $comments,'trashed' => 0]);
    }

    public function show(Comment $c)
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'content' => 'required|min:5',
            'post_id' => 'required|integer',
        ]);

        $comment = new Comment($r->all());
        $comment->user_id = Auth::user()->user_id;

        $comment->save($r->all());

        return back();
    }

    public function edit(Comment $c)
    {
        
    }

    public function update(Request $r,Comment $c)
    {
        $this->validate($r, [
            'content' => 'required|min:5',
        ]);

        $c->user_id = Auth::user()->user_id;

        $c->update($r->all());
        return back();

    }
}
