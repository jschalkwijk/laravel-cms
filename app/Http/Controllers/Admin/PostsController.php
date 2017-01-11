<?php

namespace CMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CMS\Models\Post;
use CMS\Models\Category;
use CMS\Models\UserActions;

class PostsController extends Controller
{
    use UserActions;

    public function index(){
        $posts = Post::with('categories','user')->where('posts.trashed',0)->orderBy('post_id','desc')->get();
        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 0]);
    }

    public function deleted(){
        $posts = Post::with('categories','user')->where('posts.trashed',1)->orderBy('post_id','desc')->get();

        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 1]);
    }

    public function create()
    {
        // Get all the categories associated with Post
        $categories = Category::where('type','post')->get();
        return view('admin.posts.create')->with(['categories' => $categories,'template'=>$this->adminTemplate()]);
    }

    public function store(Request $r)

    {
        $this->validate($r, [
            'title' => 'required|min:4',
            'content' => 'required|min:5',
        ]);

        $post = new Post($r->all());
        $post->user_id = Auth::user()->user_id;
        // create new ID array to add a possible new category, otherwise it wont work by adding to te $r['category_ids'] directly.
        $category_ids = $r['category_ids'];

        if(!empty($r['category'])){
            $category = new Category();
            $category->title = $r['category'];
            $category->type = $r['cat_type'];
            $category->user_id = $post->user_id;
            $category->save();
            $lastInsertID = $category->category_id;
            $category_ids[] = $lastInsertID;
        }
        $post->save($r->all());
        // Save selected categories
        $post->categories()->sync($category_ids);

        return redirect()->action('Admin\PostsController@index');
    }

    public function update(Request $r, Post $post)
    {
        if($r['confirm']) {
            $this->validate($r, [
                'title' => 'required|min:4',
                'content' => 'required|min:5',
            ]);

            $post->user_id = Auth::user()->user_id;
            // create new ID array to add a possible new category, otherwise it wont work by adding to te $r['category_ids'] directly.
            $category_ids = $r['category_ids'];

            if(!empty($r['category'])){
                $category = new Category();
                $category->title = $r['category'];
                $category->type = $r['cat_type'];
                $category->user_id = $post->user_id;
                $category->save();
                $lastInsertID = $category->category_id;
                $category_ids[] = $lastInsertID;
            }
            $post->update($r->all());
            // Save selected categories, if all are deselected , detach all relations else sync selected
            (!is_array($category_ids)) ? $post->categories()->detach() : $post->categories()->sync($category_ids);
            return back();
        }

    }

    public function edit(Post $post)
    {
        $post->load('categories.user');
        // Get all the categories associated with Post
        $categories = Category::where('type','post')->get();
        $selectedCat = [];
        foreach($post->categories as $cat){
            $selectedCat[] = $cat->category_id;
        };
        return view('admin.posts.edit')->with(['post' => $post,'categories' => $categories,'selectedCat' => $selectedCat,'template'=>$this->adminTemplate()]);
    }

    public function action(Request $r)
    {
        $this->Actions($r,'posts');
        return back();
    }
}
