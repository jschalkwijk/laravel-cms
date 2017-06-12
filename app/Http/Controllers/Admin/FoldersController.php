<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;


use CMS\Http\Controllers\Controller;
use CMS\Models\Folder;
use CMS\Models\Upload;
use CMS\Models\UserActions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FoldersController extends Controller
{
    use UserActions;

    public function index()
    {
        $folders = Folder::all();
        return view("admin.uploads.folders.folders",['template'=>$this->adminTemplate(),'folders' => $folders]);
    }

    public function show(Folder $folder)
    {
        $folders = Folder::all()->where('parent_id',$folder->folder_id);
        $files = Upload::all()->where('folder_id',$folder->folder_id);;

        return view('admin.uploads.folders.show')->with(['template' => $this->adminTemplate(), 'parent' => $folder,'folders' => $folders, 'files' => $files]);
    }
    public function create()
    {
        return view('admin.uploads.folders.create')->with(['template' => $this->adminTemplate()]);
    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|min:3',
        ]);

        $folder = new Folder($r->all());
        $folder->user_id = Auth::user()->user_id;
        $folder->path = "/public/uploads/".$folder->name;
        $result = Storage::makeDirectory('/public/uploads/'.$folder->name, 0775);
        if($result){
            if($folder->save($r->all())){
                return redirect()->action('Admin\FoldersController@index');
            } else {
             echo "error";
            }
        }
    }

    public function edit(Folder $folder)
    {
        return view("admin.uploads.folders.edit")->with(['template'=>$this->adminTemplate(),'folder' => $folder]);
    }

    public function update(Request $r, Folder $folder)
    {
        if(isset($r['submit'])){
            $this->validate($r, [
                'name' => 'required|min:3',
            ]);

            $folder->user_id = Auth::user()->user_id;
            $result = Storage::move('/public/uploads/'.$folder->name, '/public/uploads/'.$r['name']);
            if($result){
                $folder->update($r->all());
                $folder->path = "uploads/".$r['name'];
                if($folder->save($r->all())){
                    return redirect()->action('Admin\FoldersController@index');
                } else {
                    echo "error";
                }
            }
        }
    }

    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
        Storage::deleteDirectory($folder->path);
        Folder::destroy($folder->folder_id);

        return redirect()->action('Admin\FoldersController@index');
    }
    public function action(Request $r)
    {
        $this->Actions($r,'folders');
        return back();
    }
}
