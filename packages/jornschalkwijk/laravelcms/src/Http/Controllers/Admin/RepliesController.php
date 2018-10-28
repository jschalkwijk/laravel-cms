<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JornSchalkwijk\LaravelCMS\Models\Reply;

class RepliesController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Reply::class;

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
}
