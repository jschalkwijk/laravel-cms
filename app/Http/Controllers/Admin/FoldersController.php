<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;


use CMS\Http\Controllers\Controller;
use CMS\Models\Folder;
use CMS\Models\File;

class FoldersController extends Controller
{
    public function index()
    {
        $folders = Folder::all();
        $files = File::all();

        return view('admin.files.files')->with(['template' => $this->adminTemplate(), 'folders' => $folders, 'files' => $files]);
    }
}
