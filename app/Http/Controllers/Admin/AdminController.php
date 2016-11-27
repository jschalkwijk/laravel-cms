<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.admin')->with(['template' => $this->adminTemplate()]);
    }
}
