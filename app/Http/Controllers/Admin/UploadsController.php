<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\UserActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;;
use CMS\Models\Upload;
use CMS\Models\Folder;
Use CMS\Models\Action;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
    use UserActions;
    public function index()
    {
        $folders = Folder::all()->where('parent_id',0);
        $files = Upload::all();

        return view('admin.uploads.folders.show')->with(['template' => $this->adminTemplate(), 'parent' => null,'folders' => $folders, 'files' => $files]);
    }

    public function create()
    {

    }

    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'min:3',
            'parent' => 'numeric',
            'destination' => 'numeric'
        ]);
        $create = false;
        $folder = new Folder($r->all());
        $folder->user_id = Auth::user()->user_id;
        if((isset($r['parent']) && !empty($r['name'])) && $r['destination'] == 0){
            $create = true;
            $parent = Folder::findOrFail($r['parent']);
            $folder->path = $parent->path.'/'.$folder->name;
            $folder->parent_id = $parent->id();
        } else if(!isset($r['parent']) && !empty($r['name'])) {
            $create = true;
            $folder->path = "/public/uploads/".$folder->name;
        }
        // if: upload to destination folder instead of current parent folder.
        // else: upload to new folder inside the destination folder.
        if((isset($r['destination']) && $r['destination'] != 0) && !isset($r['name']) ){
            $folder = Folder::findOrFail($r['destination']);
        } else if((isset($r['destination']) && $r['destination'] != 0) && isset($r['name'])){
            $create = true;
            $parent = Folder::findOrFail($r['destination']);
            $folder->path = $parent->path.'/'.$folder->name;
            $folder->parent_id = $parent->id();
        }


        if ($create) {
            $result = Storage::makeDirectory($folder->path, 0775);
            if ($result) {
                $folder->save($r->all());
            } else {
                echo "error";
            }
        }

        if ($r->hasFile('files')) {
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
        } else {
            echo "error";
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

