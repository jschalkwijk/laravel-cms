<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use JornSchalkwijk\LaravelCMS\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Tag::class;

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
        $tag->type = $r['tag_type'];
        if($r->ajax()) {
            if ($tag->save()) {
                return response()->json(array('success' => true, 'tag' => $tag));
            } else {
                return response()->json(array('success' => false));
            }
        }

        if(!$r->ajax() && $tag->save()){
            // success flash
        } else {
            // error flash
        }

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
}
