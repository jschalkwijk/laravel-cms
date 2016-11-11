<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Folder;
use App\File;

class FoldersController extends Controller
{
    public function index()
    {
        $folders = Folder::all();
        $files = File::all();

        return view('admin.files.files')->with(['template' => $this->adminTemplate(), 'folders' => $folders, 'files' => $files]);
    }
}
