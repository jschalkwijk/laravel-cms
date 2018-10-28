<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public static function omnisearch($search){
        $results = [];
        $posts = Post::search($search)->get();
        $users = User::search($search)->get();
        $categories = Category::search($search)->get();
        $folders = Folder::search($search)->get();
        $uploads = Upload::search($search)->get();
        (!$posts->isEmpty()) ? $results['posts'] = $posts : null ;
        (!$users->isEmpty()) ? $results['users'] = $users : null ;
        (!$categories->isEmpty()) ? $results['categories'] = $categories : null ;
        (!$folders->isEmpty()) ? $results['folders'] = $folders : null ;
        (!$uploads->isEmpty()) ? $results['files'] = $uploads : null ;
        return $results;
    }
}
