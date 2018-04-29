<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;

use CMS\Http\Controllers\Controller;
use CMS\Models\Folder;
use CMS\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FoldersController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Folder::class;    public function index()
    {
        $folders = Folder::all();
        return view("admin.uploads.folders.folders",['template'=>$this->adminTemplate(),'folders' => $folders]);
    }

    public function show(Folder $folder)
    {
        $folders = Folder::all()->where('parent_id',$folder->folder_id);
        $files = Upload::with('user')->where('folder_id',$folder->folder_id)->get();
//        dd($files[0]->user());
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
        $folders = Folder::all();
        return view("admin.uploads.folders.edit")->with(['template'=>$this->adminTemplate(),'folder' => $folder,'folders' => $folders]);
    }

    public function update(Request $r, Folder $folder)
    {
        if(isset($r['submit'])) {
            $this->validate($r, [
                'name' => 'required|min:3,'.$folder->folder_id,
            ]);
            if($folder->name != $r['name']){
                // logic to change the name and also the file paths names.
//                if (Storage::move($folder->path, $destination->path . '/' . $folder->name)) {
            }
            if ($r['parent_id'] != $folder->folder_id && $r['parent_id'] != $folder->parent_id) {
                $destination = Folder::findOrFail($r['parent_id']);
                if (Storage::move($folder->path, $destination->path . '/' . $folder->name)) {
                    $folder->path = $destination->path . '/' . $folder->name;
                    $folder->user_id = Auth::user()->user_id;
                    $folder->parent_id = $r['parent_id'];
                    $folder->save();

                    if ($folder->update($r->all())) {
                        $files = Upload::where('folder_id', $folder->folder_id)->get();
                        foreach ($files as $file) {
                            $file->file_path = str_replace('/public/', '', $folder->path) . '/' . $file->file_name;
                            $file->thumb_path = str_replace('/public/', '', $folder->path) . '/thumbs/' . $file->thumb_name;
                            $file->save();
                        }

                        return redirect()->action('Admin\FoldersController@index');
                    } else {
                        echo "error";
                    }
                }
            }
        }
    }

    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
        Storage::deleteDirectory($folder->path);
        Folder::delete_recursive([$folder->id()]);
        return redirect()->action('Admin\FoldersController@index');
    }
}
