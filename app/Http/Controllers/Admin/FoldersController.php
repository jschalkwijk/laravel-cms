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

        return view('admin.uploads.uploads')->with(['template' => $this->adminTemplate(), 'folders' => $folders, 'files' => $files]);
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
        $folder->path = "public/uploads/".$folder->name;
        $result = Storage::makeDirectory('/public/uploads/'.$folder->name, 0775);
        if($result){
            if($folder->save($r->all())){
                return redirect()->action('Admin\FoldersController@index');
            } else {
             echo "error";
            }
        }

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function action()
    {

    }
}
