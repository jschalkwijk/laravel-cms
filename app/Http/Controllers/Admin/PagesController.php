<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Models\Page;
use CMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;


class PagesController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Page::class;

    public function index()
    {
        $pages = Page::with('user')->orderBy('page_id', 'desc')->get();
        return view('admin.pages.pages')->with(['template' => $this->adminTemplate(),'pages' => $pages,'trashed' => 0]);
    }

    public function deleted()
    {
        $pages = Page::with('user')->orderBy('page_id', 'desc')->get();
        return view('admin.pages.pages')->with(['template' => $this->adminTemplate(),'pages' => $pages,'trashed' => 1]);
    }

    public function show(Page $page)
    {
        return view('admin.pages.show')->with(['page' => $page,'template'=>$this->adminTemplate()]);
    }
    public function create()
    {
        return view('admin.pages.create')->with(['template'=>$this->adminTemplate()]);
    }

    public function store(Request $r)
    {
        $this->validate($r,[
            'title' => 'required|min:4',
            'content' => 'required|min:5',
            'slug'  => 'min:4',
            'template' => 'min:4'
        ]);

        $r['slug'] = (empty($r['slug']) || !isset($r['slug'])) ? str_slug($r['title'],'-') : str_slug($r['slug'],'-');

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

        $this->validate($r, [
            'title' => 'required|min:4',
            'content' => 'required|min:5',
            'slug'  => 'min:4',
            'template' => 'min:4'
        ]);

        $r['slug'] = (empty($r['slug']) || !isset($r['slug'])) ? str_slug($r['title'],'-') : str_slug($r['slug'],'-');

        $page->user_id = Auth::user()->user_id;
        $page->update($r->all());

        return back();

    }

}
