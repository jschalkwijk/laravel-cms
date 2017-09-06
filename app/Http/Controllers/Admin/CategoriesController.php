<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Category;
use CMS\Models\UserActions;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Models\Action;

class CategoriesController extends Controller
{
    use UserActions;

    public function index()
    {
        $categories = Category::with('user')->where('categories.trashed',0)->orderBy('category_id', 'desc')->get();
        return view('admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories' => $categories,'trashed' => 0]);
    }

    public function show(Category $category)
    {
        $sub_categories  = $category->treeList($category->children);
        return view('admin.categories.category')->with(['template'=>$this->adminTemplate(),'category' => $category,'sub_categories' => $sub_categories ]);
    }

    public function deleted(){
        $categories = Category::with('user')->where('categories.trashed',0)->orderBy('category_id', 'desc')->get();
        return view('admin.categories.categories')->with(['template'=>$this->adminTemplate(),'categories' => $categories,'trashed' => 0]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create')->with(['categories' => $categories,'template' => $this->adminTemplate()]);
    }
    public function store(Request $r)
    {
        $this->validate($r,[
            'title' => 'required|min:3'
        ]);

        $category = new Category($r->all());
        $category->user_id = Auth::user()->user_id;
        $category->type = 'category';
        $category->save();
        return redirect()->action('Admin\CategoriesController@index');
    }
    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('admin.categories.edit')->with(['category' => $category,'categories' => $categories, 'template' => $this->adminTemplate()]);
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
        $this->Actions(new Category(),$r);
        return back();
    }

    public function destroy($id)
    {
        $category = category::findOrFail($id);
        Category::destroy($category->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new Category(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new Category(),$id);
        return back();
    }

    public function trash($id)
    {
        Action::trash(new Category(),$id);
        return back();
    }
}
