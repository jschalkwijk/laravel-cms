<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Category;
use CMS\Models\Folder;
use CMS\Models\Post;
use CMS\Models\Upload;
use CMS\Models\User;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use CMS\Models\Search;

class SearchController extends Controller
{
    public function index(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = Search::omnisearch($r['search']);
        $results['template'] = $this->adminTemplate();
        $results['trashed'] = 0;
        return view('admin.search.show')->with($results);
    }

    public function show(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = Search::omnisearch($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('admin.search.show')->with($results);
    }

    public function posts(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $posts = Post::search($r['search'])->get();

        return view('admin.search.show')->with(['posts' => $posts,'template' => $this->adminTemplate()]);
    }

    public function categories(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $categories = Category::search($r['search'])->get();
        return view('admin.search.show')->with(['categories' => $categories,'template' => $this->adminTemplate()]);
    }

    public function users(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $users = User::search($r['search'])->get();
        return view('admin.search.show')->with(['users' => $users,'template' => $this->adminTemplate()]);
    }

    public function folders(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $folders = Folder::search($r['search'])->get();
        return view('admin.search.show')->with(['folders' => $folders,'template' => $this->adminTemplate()]);
    }

    public function uploads(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $folders = Upload::search($r['search'])->get();
        return view('admin.search.show')->with(['folders' => $folders,'template' => $this->adminTemplate()]);
    }
}
