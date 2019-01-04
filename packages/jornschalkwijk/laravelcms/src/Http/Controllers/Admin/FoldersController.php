<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;


use JornSchalkwijk\LaravelCMS\Models\Folder;
use JornSchalkwijk\LaravelCMS\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FoldersController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Folder::class;

    public function index(Request $r)
    {
        if (isset($r['search'])){
            $this->validate($r, [
                'search' => 'min:3',
            ]);
            $folders = Folder::search($r['search'])->get();
        } else {
            $folders = Folder::all();
        }

        return view("JornSchalkwijk\LaravelCMS::admin.uploads.folders.folders",['template'=>$this->adminTemplate(),'folders' => $folders]);
    }

    public function show(Folder $folder,Request $r)
    {
        $folders = Folder::all()->where('parent_id',$folder->folder_id);
        $files = $folder->files;
        $back = '/admin/folders/'.$folder->parent_id;
        if($r->ajax()){
            $html = view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.show')->with(['template' => $this->adminTemplate(), 'folder' => $folder,'folders' => $folders, 'uploads' => $files,'back' => $back])->renderSections()['content'];
            return response()->json(['success' => true,'html' => $html]);
        }
        return view('JornSchalkwijk\LaravelCMS::admin.uploads.folders.show')->with(['template' => $this->adminTemplate(), 'folder' => $folder,'folders' => $folders, 'files' => $files]);
    }
    public function create()
    {
        return view('JornSchalkwijk\LaravelCMS::admin.uploads.folders.create')->with(['template' => $this->adminTemplate()]);
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

        $this->validate($r, [
            'name' => 'required|min:3,' . $folder->folder_id,
        ]);

        if ($folder->name != $r['name']) {
            // logic to change the name and also the file paths names.
            $folder->update($r->all());
        }
        if ($r['parent_id'] != $folder->folder_id && $r['parent_id'] != $folder->parent_id) {
            $destination = Folder::findOrFail($r['parent_id']);
            $folder->user_id = Auth::user()->user_id;
            $folder->parent_id = $destination->folder_id;
            $folder->save();
        }

        if ($r['copy_id'] != $folder->folder_id && $r['copy_id'] != $folder->parent_id) {
            $destination = Folder::findOrFail($r['copy_id']);
            $copied_folder = $folder->replicate(['parent_id','user_id']);
            $copied_folder->parent_id = $destination->folder_id;
            $copied_folder->user_id = Auth::user()->user_id;
            $copied_folder->save();
            $folder_files = $folder->files->pluck('upload_id')->toArray();
            $copied_folder->files()->attach($folder_files);
        }

        return redirect()->action('Admin\FoldersController@index');

    }

    public function destroy($id)
    {
        $folder = Folder::findOrFail($id);
//        Storage::deleteDirectory($folder->path);
        Folder::delete_recursive([$folder->id()]);
//        return redirect()->action('Admin\FoldersController@index');
    }
}
