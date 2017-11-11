<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Comment;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    //
    public function index()
    {
        $comments = Comment::all();
        return view('admin.comments.comments')->with(['template'=>$this->adminTemplate(),'comments' => $comments]);
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
        
    }

    public function destroy($id)
    {

    }

    public function action(Request $r)
    {
        
    }

    public function approve($id)
    {

    }

    public function hide($id)
    {

    }

    public function trash($id)
    {

    }
}
