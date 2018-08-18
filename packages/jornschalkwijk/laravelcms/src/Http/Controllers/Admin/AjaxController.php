<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;
    use Illuminate\Http\Request;

    use CMS\Http\Controllers\Controller;

    class AjaxController extends Controller
    {

        public function index(){
            return view('admin.ajax.ajax');
        }
        public function ajax(Request $r)
        {
            $test = $r['name'];

            return response()->json(['success'=>'Data is successfully added','html' => '<h1>HTML</h1>']);
        }

    }