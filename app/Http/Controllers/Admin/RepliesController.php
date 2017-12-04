<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use CMS\Models\Action;

use CMS\Models\Reply;

class RepliesController extends Controller
{
    //
    public function index()
    {
        $replies = Reply::with('user','comment')->orderBy('reply_id','DESC')->get();
        return view('admin.comments.replies.replies')->with(['template'=>$this->adminTemplate(),'replies' => $replies]);
    }

    public function show(Reply $c)
    {

    }

    public function create()
    {

    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'comment_id' => 'required|integer',
            'content' => 'required|min:5',
        ]);

        $reply = new Reply($r->all());
        $reply->user_id = Auth::user()->user_id;
        $reply->save($r->all());
        return back();

    }

    public function edit(Reply $c)
    {

    }

    public function update(Request $r,Reply $c)
    {

    }

    public function destroy($id)
    {
        $post = Reply::findOrFail($id);
        Reply::destroy($post->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new Reply(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new Reply(),$id);
        return back();
    }
}
