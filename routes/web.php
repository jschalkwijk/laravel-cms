<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => '/admin'], function (){
    // Authentication Routes...
    $this->get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    $this->post('/login', 'Admin\Auth\LoginController@login');
    $this->post('/logout', 'Admin\Auth\LoginController@logout')->name('logout');
    // Registration Routes...
//    $this->get('register', 'Auth\RegisterController@showRegistrationForm');
//    $this->post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...
    $this->get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
    $this->post('/password/reset', 'Admin\Auth\ResetPasswordController@reset');

    Route::get('/', 'Admin\AdminController@index');
//

    Route::group(['middleware' => 'auth'], function()
    {
    /*
     * Artisan route:list makes the controller routes and then you only have to use one Route function.
     *  Route::resource('posts','Admin\PostsController');
     * Later kijken hoe ik dit ga toepassen
         posts.store
         posts.index
         posts.destroy
         posts.update
         posts.show
         posts.edit
     * These routes get created automaticlly after route:list
        Route::get('/', 'Admin\PostsController@index');
        Route::get('/create', 'Admin\PostsController@create');
        Route::put('/store', 'Admin\PostsController@store');
        Route::get('/edit/{post}', 'Admin\PostsController@edit');
        Route::patch('/update/{post}', 'Admin\PostsController@upgitdate');
    */
        Route::group(['prefix' => '/posts'],function(){
            Route::get('/deleted-posts', 'Admin\PostsController@deleted');
            Route::post('/action', 'Admin\PostsController@action');
        });
        Route::resource('posts','Admin\PostsController');
    });

    Route::group(['middleware' => 'auth'], function() {
        Route::group(['prefix' => '/categories'],function(){
            Route::get('/deleted-categories','Admin\CategoriesController@deleted');
            Route::post('/action', 'Admin\CategoriesController@action');
        });
        Route::resource('categories','Admin\CategoriesController');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::group(['prefix' => '/users'],function(){
            Route::get('/deleted-users', 'Admin\UsersController@deleted');
            Route::post('/action', 'Admin\UsersController@action');
        });
        Route::resource('users','Admin\UsersController');
    });

    Route::group(['prefix' => 'pages','middleware' => 'auth'], function(){
       Route::get('/','Admin\PagesController@index');
       Route::get('/add','Admin\PagesController@add');
       Route::get('/new','Admin\PagesController@edit');
       Route::get('/edit/{page}/{title}','Admin\PagesController@edit');
       Route::get('/update/{page}/{title}','Admin\PagesController@update');
    });

    Route::group(['prefix' => 'files','middleware' => 'auth'], function(){
        Route::get('/','Admin\FilesController@index');
        Route::get('/add','Admin\FilesController@add');
        Route::get('/new','Admin\FilesController@edit');
        Route::get('/edit/{file}/{name}','Admin\FilesController@edit');
        Route::get('/update/{file}/{name}','Admin\FilesController@update');
        Route::auth();
    });

    Route::get('/cards', 'Cards@index');
    Route::get('/cards/{card}', 'Cards@show');

    Route::post('/cards/{card}/notes', 'Notes@store');
    Route::get('/notes/{note}/edit','Notes@edit');
    Route::patch('/notes/{note}','Notes@update');

});

Route::get('/', 'pages@home');

Route::get('/about','pages@about');
Route::get('/skills','pages@skills');

Route::get('/blog', 'Posts@index');
Route::get('/blog/{post}', 'Posts@show');

Route::get('/categories', 'Categories@index');
Route::get('/categories/{category}', 'Categories@show');



Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
