<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use CMS\Models\Upload;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use CMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CMS\Models\Gallery;

class GalleriesController extends Controller
{
    use ControllerActionsTrait;

    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.uploads.galleries.galleries')->with(['galleries' => $galleries,'template' => $this->adminTemplate()]);
    }


    public function create()
    {

    }

    public function store(Request $r)
    {
        $gallery = new Gallery($r->all());
        if($r->ajax()) {
            if ($gallery->save()) {
                return response()->json(array('success' => true, 'gallery' => $gallery));
            } else {
                return response()->json(array('success' => false));

            }
        };
        if(!$r->ajax() && $gallery->save()){
            // success flash
        } else {
            // error flash
        }
        return back();
    }

    public function attach(Request $r)
    {
        $gallery = Gallery::find($r['gallery_id']);
        $gallery->uploads()->attach($r['images']);
        return response()->json(array('success' => true));
    }

    public function show(Request $r,$id)
    {
        $gallery = Gallery::find($id);
        if($r->ajax()) {
            if ($gallery) {
                $returnHTML = view('admin.uploads.partials.gallery')->with('uploads', $gallery->uploads)->renderSections()['content'];
                return response()->json(array('success' => true, 'html' => $returnHTML));
            } else {
                return response()->json(array('success' => false));

            }
        };
        if(!$r->ajax() && $gallery){
            // success flash
        } else {
            // error flash
        }
        return back();
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
