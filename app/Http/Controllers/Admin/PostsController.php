<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Action;
use CMS\Models\Tag;
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

        $posts = Post::with('category','user','tags:title')->where('posts.trashed',0)->orderBy('post_id','desc')->get();
        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=> $posts,'trashed' => 0]);
    }

    public function show(Post $post)
    {
        return view('admin.posts.show')->with(['template'=>$this->adminTemplate(),'post' => $post]);
    }

    public function deleted(){
        $posts = Post::with('category','user','comments')->where('posts.trashed',1)->orderBy('post_id','desc')->get();

        return view('admin.posts.posts')->with(['template'=>$this->adminTemplate(),'posts'=>$posts,'trashed' => 1]);
    }

    public function create()
    {
        // Get all the categories associated with Post
        $categories = Category::where('type','post')->get();
        $tags = Tag::where('type','post')->get();
        return view('admin.posts.create')->with(['categories' => $categories,'tags' => $tags,'template'=>$this->adminTemplate()]);
    }

    public function store(Request $r)

    {
        $this->validate($r, [
            'title' => 'required|min:4',
            'content' => 'required|min:5',
        ]);

        $post = new Post($r->all());
        $post->user_id = Auth::user()->user_id;

        $post->save();

        if(!empty($r['category'])){
            $category = new Category();
            $category->title = $r['category'];
            $category->type = $r['cat_type'];
            $category->user_id = $post->user_id;
            $category->save();
            $lastInsertID = $category->category_id;
            $category_ids[] = $lastInsertID;
        }

        $tag_ids = $r['tag_ids'];

        if(!empty($r['tag'])){
            $multiple = explode('|',$r['tag']);
            foreach($multiple as $tagName) {
                $tag = new Tag();
                $tag->title = trim($tagName);
                $tag->type = $r['tag_type'];
                $tag->user_id = $post->user_id;
                $tag->save();
                $lastInsertID = $tag->tag_id;
                $tag_ids[] = $lastInsertID;
            }
        }
        // Save selected categories, if all are deselected , detach all relations else sync selected
        $post->tags()->sync($tag_ids);
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

            $tag_ids = $r['tag_ids'];

            if(!empty($r['tag'])){
                $multiple = explode('|',$r['tag']);
                foreach($multiple as $tagName) {
                    $tag = new Tag();
                    $tag->title = trim($tagName);
                    $tag->type = $r['tag_type'];
                    $tag->user_id = $post->user_id;
                    $tag->save();
                    $lastInsertID = $tag->tag_id;
                    $tag_ids[] = $lastInsertID;
                }
            }
            // Save selected tags, if all are deselected , detach all relations else sync selected
            (!is_array($tag_ids)) ? $post->tags()->detach() : $post->tags()->sync($tag_ids);
        }
        return back();
    }

    public function edit(Post $post)
    {
        $post->load('category.user');
        // Get all the categories associated with Post
        $categories = $categories = Category::where('type','post')->get();
        $tags = Tag::where('type', 'post')->get();
        $selectedTag = [];
        foreach ($post->tags as $tag) {
            $selectedTag[] = $tag->tag_id;
        };

        return view('admin.posts.edit')->with(['post' => $post, 'categories' => $categories, 'tags' => $tags, 'selectedTag' => $selectedTag,'template'=>$this->adminTemplate()]);
    }

    public function action(Request $r,Post $post)
    {
        $this->Actions($post,$r);
        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Post::destroy($post->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new Post(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new Post(),$id);
        return back();
    }

    public function trash($id)
    {
        Action::trash(new Post(),$id);
        return back();
    }
}
