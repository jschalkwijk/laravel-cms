<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;
    use Illuminate\Http\Request;



    class AjaxController extends Controller
    {

        public function index(){
            return view('JornSchalkwijk\LaravelCMS::admin.ajax.ajax');
        }
        public function ajax(Request $r)
        {
            $test = $r['name'];

            return response()->json(['success'=>'Data is successfully added','html' => '<h1>HTML</h1>']);
        }

    }