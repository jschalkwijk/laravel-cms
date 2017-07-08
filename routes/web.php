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
        Route::resource('posts','Admin\PostsController',['except' => ['show']]);
        Route::group(['prefix' => '/posts'],function(){
            Route::get('/deleted-posts', 'Admin\PostsController@deleted');
            Route::post('/action', 'Admin\PostsController@action');
            Route::get('/{id}/approve','Admin\PostsController@approve')->name('posts.approve');
            Route::get('/{id}/hide','Admin\PostsController@hide')->name('posts.hide');
            Route::get('/{id}/destroy', 'Admin\PostsController@destroy')->name('posts.destroy');
            Route::get('/{id}/trash', 'Admin\PostsController@trash')->name('posts.trash');
        });
        /*
         * Artisan route:list makes the controller routes and then you only have to use one Route function.
         *  Route::resource('posts','Admin\PostsController');
         posts.store
         posts.index
         posts.destroy
         posts.update
         posts.show
         posts.edit
        */
    });

    Route::group(['middleware' => 'auth'], function() {
        Route::resource('categories','Admin\CategoriesController',['except' => ['show']]);
        Route::group(['prefix' => '/categories'],function(){
            Route::get('/deleted-categories','Admin\CategoriesController@deleted');
            Route::post('/action', 'Admin\CategoriesController@action');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('tags','Admin\TagsController',['except' => ['show']]);
        Route::group(['prefix' => '/tags'],function(){
            Route::post('/action', 'Admin\TagsController@action');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('users','Admin\UsersController',['except' => ['show','destroy']]);
        Route::group(['prefix' => '/users'],function(){
            Route::get('/deleted-users', 'Admin\UsersController@deleted');
            Route::post('/action', 'Admin\UsersController@action');
        });
    });

    Route::group(['prefix' => 'pages','middleware' => 'auth'], function(){
       Route::get('/','Admin\PagesController@index');
       Route::get('/add','Admin\PagesController@add');
       Route::get('/new','Admin\PagesController@edit');
       Route::get('/edit/{page}/{title}','Admin\PagesController@edit');
       Route::get('/update/{page}/{title}','Admin\PagesController@update');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('uploads','Admin\UploadsController',['except' => 'show','destroy']);
        Route::group(['prefix'=>'/uploads'],function(){
            Route::get('/{id}/destroy', 'Admin\UploadsController@destroy')->name('uploads.destroy');
            Route::post('/action', 'Admin\UploadsController@action');
        });
    });
    Route::group(['middleware' => 'auth'],function(){
        Route::resource('folders','Admin\FoldersController',['except' => 'destroy']);
        Route::group(['prefix'=>'/folders'],function(){
            Route::get('/{id}/destroy', 'Admin\FoldersController@destroy')->name('folders.destroy');
            Route::post('/action', 'Admin\FoldersController@action')->name('folders.action');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('products','Admin\ProductsController',['except' => ['show']]);
        Route::group(['prefix' => '/products'],function(){
            Route::get('/deleted-products','Admin\ProductsController@deleted');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('contacts','Admin\ContactsController',['except' => ['show']]);
        Route::group(['prefix' => '/contacts'],function(){
            Route::get('/deleted-contacts','Admin\ContactsController@deleted');
            Route::post('/action', 'Admin\ContactsController@action');
        });
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