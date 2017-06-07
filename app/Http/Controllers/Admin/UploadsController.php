<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\UserActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;;
use CMS\Models\Upload;
use CMS\Models\Folder;
Use CMS\Models\Action;

class UploadsController extends Controller
{
    use UserActions;
    public function index()
    {
        $folders = Folder::all()->where('parent_id',0);
        $files = Upload::all();

        return view('admin.uploads.uploads')->with(['template' => $this->adminTemplate(), 'folders' => $folders, 'files' => $files]);
    }

    public function create()
    {

    }

    public function store(Request $r)
    {
        if ($r->hasFile('files')) {
            foreach ($r->file('files') as $upload) {
                $original_name = $upload->getClientOriginalName();
                $type = $upload->getClientOriginalExtension();
                $size = $upload->getClientSize();
                $file_name = $upload->hashName();
                $file_path = 'uploads/'.$file_name;
                if($upload->store('/public/uploads')){
                    $file = new Upload();
                    $file->name = $original_name;
                    $file->file_name = $file_name;
                    $file->size = $size;
                    $file->type = $type;
                    $file->file_path = $file_path;
                    $file->user_id = Auth::user()->user_id;
                    $file->save();
                    return redirect()->action('Admin\UploadsController@index');
                };
            }
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

