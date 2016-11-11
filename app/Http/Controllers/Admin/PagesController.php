<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Page;


class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::with('category','user')->orderBy('page_id', 'desc')->get();
        return view('admin.pages.pages')->with(['template' => $this->adminTemplate(),'pages' => $pages]);
    }

    public function add(Request $r)
    {
        $this->validate($r,[
            'title' => 'required|min:4',
            'content' => 'required|min:5',
        ]);

        $page = new Page($r->all());
        $page->user_id = Auth::user()->user_id;
        $page->save();
        return back();

    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit')->with(['page' => $page,'template'=>$this->adminTemplate()]);
    }

    public function update(Request $r, Page $page)
    {
        if($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:4',
                'content' => 'required|min:5',
            ]);

            $page->user_id = Auth::user()->user_id;
            $page->update($r->all());
            return back();
        }

    }
}
