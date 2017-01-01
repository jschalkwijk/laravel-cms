<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Category;
use CMS\Models\UserActions;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    use UserActions;

    public function index()
    {
        $categories = Category::with('user')->where('categories.trashed',0)->orderBy('category_id', 'desc')->get();
        return view('admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories' => $categories,'trashed' => 0]);
    }

    public function deleted(){
        $categories = Category::with('user')->where('categories.trashed',1)->get();

        return view('admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories'=>$categories,'trashed' => 1]);
    }

    public function create()
    {
        return view('admin.categories.create')->with(['template' => $this->adminTemplate()]);
    }
    public function store(Request $r)
    {
        $this->validate($r,[
            'title' => 'required|min:3'
        ]);

        $category = new Category($r->all());
        $category->user_id = Auth::user()->user_id;
        $category->type = 'post';
        $category->save();
        return redirect()->action('Admin\CategoriesController@index');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit')->with(['category' => $category, 'template' => $this->adminTemplate()]);
    }

    public function update(Request $r, Category $category)
    {
        if ($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:3'
            ]);

            $category->user_id = Auth::user()->user_id;
            $category->update($r->all());
            return back();
        }
    }

    public function action(Request $r)
    {
        $this->Actions($r,'categories');
        return back();
    }
}
