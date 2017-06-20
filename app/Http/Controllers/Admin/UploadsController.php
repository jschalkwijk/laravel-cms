<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\UserActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use CMS\Models\Upload;
use CMS\Models\Folder;

class UploadsController extends Controller
{
    use UserActions;
    public function index()
    {
        $folders = Folder::all()->where('parent_id',0);

        return view('admin.uploads.folders.show')->with(['template' => $this->adminTemplate(), 'parent' => null,'folders' => $folders]);
    }

    public function create()
    {

    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'unique:folders,name|min:3',
            'parent' => 'numeric',
            'destination' => 'required|numeric',
            'files' => 'required',
        ]);

        $folder = Folder::create($r);

        foreach ($r->file('files') as $upload) {
            $original_name = $upload->getClientOriginalName();
            $type = $upload->getClientOriginalExtension();
            $size = $upload->getClientSize();
            $file_name = $upload->hashName();
            $file_path = str_replace('/public/','',$folder->path).'/'.$file_name;
            if($upload->store($folder->path)){
                $file = new Upload();
                $file->name = $original_name;
                $file->file_name = $file_name;
                $file->size = $size;
                $file->type = $type;
                $file->file_path = $file_path;
                $file->user_id = Auth::user()->user_id;
                $file->folder_id = $folder->id();
                $file->save();
            };
        }
        return back();

    }

    public function edit()
    {

    }

    public function update()
    {

    }
    public function action(Request $r)
    {
        $this->Actions($r,'uploads');
        return back();
    }
}

