<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('user')->orderBy('category_id', 'desc')->get();
        return view('admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories' => $categories]);
    }

    public function add(Request $r)
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
}
