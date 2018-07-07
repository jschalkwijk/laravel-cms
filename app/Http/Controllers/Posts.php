<?php

namespace CMS\Http\Controllers;

use Laravel\Scout\Searchable;
use ScoutElastic\SearchableModel;

use CMS\Post;

class Posts extends Controller
{
    use Searchable;

    public function show(Post $post){
			return view('posts.show')->with(['template'=>$this->template(),'post'=>$post]);
	}
}
