<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\UserActions;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Models\Page;
use CMS\Models\Action;


class PagesController extends Controller
{
    use UserActions;

    public function index()
    {
        $pages = Page::with('user')->orderBy('page_id', 'desc')->get();
        return view('admin.pages.pages')->with(['template' => $this->adminTemplate(),'pages' => $pages,'trashed' => 0]);
    }

    public function show(Page $page)
    {
        return view('admin.pages.show')->with(['page' => $page,'template'=>$this->adminTemplate()]);
    }
    public function create(Page $page)
    {
        return view('admin.pages.create')->with(['page' => $page,'template'=>$this->adminTemplate()]);
    }

    public function store(Request $r)
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
        return view('admin.pages.create')->with(['page' => $page,'template'=>$this->adminTemplate()]);
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
        }
        
        return back();

    }

    public function action(Request $r,Page $page)
    {
        $this->Actions($page,$r);
        return back();
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        Page::destroy($page->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new Page(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new Page(),$id);
        return back();
    }

    public function trash($id)
    {
        Action::trash(new Page(),$id);
        return back();
    }
}
