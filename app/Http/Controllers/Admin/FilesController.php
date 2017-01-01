<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Models\File;
use CMS\Models\Folder;

class FilesController extends Controller
{
    public function index()
    {
        $folders = Folder::all();
        $files = File::all();

        return view('admin.files.files')->with(['template' => $this->adminTemplate(), 'folders' => $folders, 'files' => $files]);
    }
}
