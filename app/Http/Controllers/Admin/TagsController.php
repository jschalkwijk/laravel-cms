<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\UserActions;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use CMS\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    use UserActions;

    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.tags')->with(
            [
                'tags' => $tags,
                'template'=>$this->adminTemplate(),
            ]
        );
    }

    public function store(Request $r){
        $this->validate($r, [
            'title' => 'required|min:3'
        ]);
        $tag = new Tag($r->all());
        $tag->user_id = Auth::user()->user_id;
        $tag->save();
        return back();
    }
    public function update(Request $r,Tag $tag){

        if ($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:3'
            ]);

            $tag->user_id = Auth::user()->user_id;
            $tag->update($r->all());
            return back();
        }
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit')->with(
            [
                'tag' =>$tag,
                'template'=>$this->adminTemplate(),
            ]
        );
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back();
    }

    public function action(Request $r)
    {
        $this->Actions($r,'tags');
        return back();
    }

}
