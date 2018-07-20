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
        $results = Post::search($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('admin.search.show')->with($results);
    }

    public function categories(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = Category::search($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('admin.search.show')->with($results);
    }

    public function users(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = User::search($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('admin.search.show')->with($results);
    }

    public function folders(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = Folder::search($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('admin.search.show')->with($results);
    }

    public function uploads(Request $r)
    {
        $this->validate($r, [
            'search' => 'min:3',
        ]);
        $results = Upload::search($r['search']);
        $results['template'] = $this->adminTemplate();
        return view('admin.search.show')->with($results);
    }
}
