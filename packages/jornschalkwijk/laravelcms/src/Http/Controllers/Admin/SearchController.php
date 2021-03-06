<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Models\Category;
use JornSchalkwijk\LaravelCMS\Models\Folder;
use JornSchalkwijk\LaravelCMS\Models\Post;
use JornSchalkwijk\LaravelCMS\Models\Upload;
use JornSchalkwijk\LaravelCMS\Models\User;
use JornSchalkwijk\LaravelCMS\Models\Page;
use Illuminate\Http\Request;

use JornSchalkwijk\LaravelCMS\Models\Search;

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
        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with($results);
    }

    public function show(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = Search::omnisearch($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with($results);
    }

    public function posts(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $posts = Post::search($r['search'])->get();

        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with(['posts' => $posts,'template' => $this->adminTemplate()]);
    }
    public function pages(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $pages = Page::search($r['search'])->get();

        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with(['pages' => $pages,'template' => $this->adminTemplate()]);
    }

    public function categories(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $categories = Category::search($r['search'])->get();
        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with(['categories' => $categories,'template' => $this->adminTemplate()]);
    }

    public function users(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $users = User::search($r['search'])->get();
        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with(['users' => $users,'template' => $this->adminTemplate()]);
    }

    public function folders(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $folders = Folder::search($r['search'])->get();
        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with(['folders' => $folders,'template' => $this->adminTemplate()]);
    }

    public function uploads(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $folders = Upload::search($r['search'])->get();
        return view('JornSchalkwijk\LaravelCMS::admin.search.show')->with(['folders' => $folders,'template' => $this->adminTemplate()]);
    }
}
