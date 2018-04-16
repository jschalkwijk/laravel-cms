<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Http\Controllers\Admin\ControllerActionsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use CMS\Models\Upload;
use CMS\Models\Folder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadsController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Upload::class;
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
            $thumb_name = 'thumb_'.$upload->hashName();
            $file_path = str_replace('/public/','',$folder->path).'/'.$file_name;
            $thumb_path = str_replace('/public/','',$folder->path).'/thumbs/'.$thumb_name;
            if($upload->store($folder->path)){
                $file = new Upload();
                $file->name = $original_name;
                $file->file_name = $file_name;
                $file->thumb_name = $thumb_name;
                $file->size = $size;
                $file->type = $type;
                $file->file_path = $file_path;
                $file->thumb_path = $thumb_path;
                $file->user_id = Auth::user()->user_id;
                $file->folder_id = $folder->id();
                $file->save();
            };
            $img = Image::make($upload->getRealPath());
            $img->fit(100,100)->save(storage_path('app'.$folder->path.'/thumbs/'.'thumb_'.$file_name));
        }
        return back();

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy($id)
    {
        $file = Upload::findOrFail($id);
        Storage::delete('public/'.$file->file_path);
        Storage::delete('public/'.$file->thumb_path);
        Upload::destroy($file->id());
        return back();
    }
}

