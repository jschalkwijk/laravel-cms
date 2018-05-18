<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use CMS\Models\Upload;
use CMS\Models\Folder;
use Illuminate\Support\Facades\DB;
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
//            $original_name = $upload->getClientOriginalName();
//            $type = $upload->getClientOriginalExtension();
//            $size = $upload->getClientSize();
//            $file_name = $upload->hashName();
//            $file_name = md5_file($upload->getRealPath());
//            $thumb_name = 'thumb_'.$upload->hashName();
//            $file_path = str_replace('/public/','',$folder->path).'/'.$file_name;
//            $thumb_path = str_replace('/public/','',$folder->path).'/thumbs/'.$thumb_name;
//            if($upload->store($folder->path)){
//                $file = new Upload();
//                $file->name = $original_name;
//                $file->file_name = $file_name;
//                $file->thumb_name = $thumb_name;
//                $file->size = $size;
//                $file->type = $type;
//                $file->file_path = $file_path;
//                $file->thumb_path = $thumb_path;
//                $file->user_id = Auth::user()->user_id;
//                $file->folder_id = $folder->id();
//                $file->save();
//            };

            /* Saving files with MD5_file hash, create directory structure from the hash. Create file paths from the file names.
             * This will eliminate the use of storing files and folder paths in teh database. When 'moving' or renaming folders we dont
             * have to worry about changing a lot of records holding file paths. Downside, when removing files, there will be a lot of
             * empty folders created, because of the way we create them with the md5Hash. How to solve this or remove folders on
             * a scheduled basis with Cronjobs for instance? Same when uploading a duplicate file, it will just create a row on the table that references
             * to the same file path. But if we delete a record that is linked to multiple folder records, we need to check everytime before actually deleting the file
             * if there are more then 1 references to that file.
             *
             * I can also try to create another folder structure with date and time 2018-04-30-18:00:18:01
            */
            $original_name = $upload->getClientOriginalName();
            $type = $upload->getClientOriginalExtension();
            $size = $upload->getClientSize();
            $file_name = md5_file($upload->getRealPath()).'.'.$type;

            $folder->createDirFromFileName($file_name);

            $path = $folder->createPathFromFileName($file_name).'/'.$file_name;

            if(!Storage::exists('/public/uploads/original/'.$path)){
                $upload->storeAs('/public/uploads/original/'.$folder->createPathFromFileName($file_name),$file_name);
                $file = new Upload();
                $file->name = $original_name;
                $file->file_name = $file_name;
                $file->size = $size;
                $file->type = $type;
                $file->user_id = Auth::user()->user_id;
                $file->folder_id = $folder->id();
                $file->save();

                $img = Image::make($upload->getRealPath());
                $img->fit(100,100)->save(storage_path('app/public/uploads/thumbnail/'.$path));
                $img->fit(150,150)->save(storage_path('app/public/uploads/small/'.$path));
                $img->fit(300,300)->save(storage_path('app/public/uploads/medium/'.$path));
                $img->resize(768, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/uploads/medium_large/'.$path));
                $img->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path('app/public/uploads/large/'.$path));
            } else {
                $file = Upload::with('folders')->where('file_name',$file_name)->first();
            }

            if(!$file->folders->contains($folder->folder_id)){
                $file->folders()->attach($folder->folder_id);
            }
        }
        return back();

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy($upload_id,$folder_id)
    {
        $upload = Upload::findOrFail($upload_id);
        $folder = Folder::findOrFail($folder_id)->files();
        $folder->detach($upload_id);
        $reference = DB::table('folders_uploads')->select()->where('upload_id','=',$upload_id)->get();
        if($reference->count() == 0){
            Upload::destroy($upload->upload_id);
        }
//        Storage::delete('public/'.$file->file_path);
//        Storage::delete('public/'.$file->thumb_path);
//        Upload::destroy($file->id());
        return back();
    }
}

