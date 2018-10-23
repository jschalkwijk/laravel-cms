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

/* Backend Routes */
    Route::group(['prefix' => '/admin','middleware' => ['web']], function (){
        // Authentication Routes...
        Route::get('/login', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('login');
        Route::post('/login', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\LoginController@login');
        Route::post('/logout', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\LoginController@logout')->name('logout');
        // Registration Routes...
//    $this->get('register', 'Auth\RegisterController@showRegistrationForm');
//    $this->post('register', 'Auth\RegisterController@register');
        // Password Reset Routes...
        Route::get('/password/reset', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\ForgotPasswordController@showLinkRequestForm');
        Route::post('/password/email', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::post('/password/reset/{token}', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\ResetPasswordController@showResetForm');
        Route::post('/password/reset', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth\ResetPasswordController@reset');

        Route::group(['middleware' => ['auth','role:admin,author']], function()
        {
            Route::get('/ajax','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\AjaxController@index');
            Route::post('/ajax/test','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\AjaxController@ajax');
            Route::resource('pages','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController');
            Route::group(['prefix' =>'/pages'],function (){
                Route::get('/deleted-pages', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController@action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController@approve')->name('pages.approve')->middleware('permission:approve hide page');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController@hide')->name('pages.hide')->middleware('permission:approve hide page');
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController@destroy')->name('pages.destroy')->middleware('permission:delete page');
                Route::get('/id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PagesController@trash')->name('pages.trash')->middleware('permission:trash page');
            });
            Route::resource('posts','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController');
            Route::group(['prefix' => '/posts'],function(){
                Route::get('/deleted-posts', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController@action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController@approve')->name('posts.approve')->middleware('permission:approve hide post');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController@hide')->name('posts.hide')->middleware('permission:approve hide post');
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController@destroy')->name('posts.destroy')->middleware('permission:delete post');
                Route::get('/id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController@trash')->name('posts.trash')->middleware('permission:trash post');
            });
            /*
             * Artisan route:list makes the controller routes and then you only have to use one Route function.
             *  Route::resource('posts','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PostsController');
             posts.store
             posts.index
             posts.destroy
             posts.update
             posts.show
             posts.edit
            */

            Route::resource('comments','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CommentsController');
            Route::group(['prefix' => '/comments'],function(){
                Route::post('/action','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CommentsController@action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CommentsController@approve')->name('comments.approve');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CommentsController@hide')->name('comments.hide');
                Route::get('/{id}/destroy','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CommentsController@destroy')->name('comments.destroy');
                Route::get('/{id}/trash','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CommentsController@trash')->name('comments.trash');
            });

            Route::resource('replies','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RepliesController');
            Route::group(['prefix'=> '/replies'],function(){
                Route::post('/action','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RepliesController@action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RepliesController@approve')->name('replies.approve');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RepliesController@hide')->name('replies.hide');
                Route::get('/{id}/destroy','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RepliesController@destroy')->name('replies.destroy');
            });

            Route::resource('categories','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController');
            Route::group(['prefix' => '/categories'],function(){
                Route::get('/deleted-categories','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController@action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController@approve')->name('categories.approve');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController@hide')->name('categories.hide');
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController@destroy')->name('categories.destroy');
                Route::get('/{id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\CategoriesController@trash')->name('categories.trash');
            });

            Route::resource('tags','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\TagsController',['except' => ['show']]);
            Route::group(['prefix' => '/tags'],function(){
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\TagsController@action');
            });

            Route::group(['middleware' => ['auth','role:admin']],function () {
                Route::resource('users', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController', ['except' => ['destroy']]);
                Route::group(['prefix' => '/users'], function () {
                    Route::get('/deleted-users', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController@deleted');
                    Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController@action');
                    Route::get('/{id}/approve', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController@approve')->name('users.approve');
                    Route::get('/{id}/hide', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController@hide')->name('users.hide');
                    Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController@destroy')->name('users.destroy');
                    Route::get('/{id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UsersController@trash')->name('users.trash');
                });
            });

            Route::resource('roles','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController');
            Route::group(['prefix' => '/roles'],function(){
                Route::get('/deleted-roles', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController@action')->name('roles.action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController@approve')->name('roles.approve')->middleware('permission:approve hide role');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController@hide')->name('roles.hide')->middleware('permission:approve hide role');
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController@destroy')->name('roles.destroy')->middleware('permission:delete role');
                Route::get('/id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\RolesController@trash')->name('roles.trash')->middleware('permission:trash role');
            });


            /* Permissions */
            Route::resource('permissions','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController');
            Route::group(['prefix' => '/permissions'],function(){
                Route::get('/deleted-permissions', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController@action')->name('permissions.action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController@approve')->name('permissions.approve')->middleware('permission:approve hide permission');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController@hide')->name('permissions.hide')->middleware('permission:approve hide permission');
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController@destroy')->name('permissions.destroy')->middleware('permission:delete permission');
                Route::get('/id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\PermissionsController@trash')->name('permissions.trash')->middleware('permission:trash permission');
            });

            Route::resource('uploads','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UploadsController',['except' => 'show','destroy']);
            Route::group(['prefix'=>'/uploads'],function(){
                Route::get('/{upload_id}/{folder_id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UploadsController@destroy')->name('uploads.destroy');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\UploadsController@action');
            });

            Route::resource('folders','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FoldersController',['except' => 'destroy']);
            Route::group(['prefix'=>'/folders'],function(){
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FoldersController@destroy')->name('folders.destroy');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FoldersController@action')->name('folders.action');
            });

            Route::resource('file-manager','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController',['only' => 'index']);
            Route::group(['prefix' =>'/file-manager'],function (){
                Route::post('/search','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@search');
                Route::get('/gallery/{id}','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@gallery');
                Route::post('/create-gallery','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@createGallery');
                Route::post('/add-to-gallery','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@addToGallery');
                Route::post('/remove-from-gallery','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@removeFromGallery');
                Route::post('/add-gallery','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@addGalleryToEditor');
                Route::get('/folders','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\FileManagerController@folders');
            });

            Route::resource('galleries','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\GalleriesController',['except' => 'destroy']);
            Route::group(['prefix'=>'/galleries'],function(){

            });
            Route::resource('products','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController');
            Route::group(['prefix' => '/products'],function(){
                Route::get('/deleted-products','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@action');
                Route::get('/{id}/approve','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@approve')->name('products.approve');
                Route::get('/{id}/hide','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@hide')->name('products.hide');
                Route::get('/{id}/destroy', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@destroy')->name('products.destroy');
                Route::get('/{id}/trash', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ProductsController@trash')->name('products.trash');
            });

            Route::resource('contacts','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ContactsController',['except' => ['show']]);
            Route::group(['prefix' => '/contacts'],function(){
                Route::get('/deleted-contacts','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ContactsController@deleted');
                Route::post('/action', 'JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\ContactsController@action');
            });

            // Elastic Search
            Route::resource('search','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController',['except' => ['show']]);
            Route::group(['prefix' => '/search'],function(){
                Route::get('/show','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController@show')->name('search.show');
                Route::get('/posts','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController@posts')->name('search.posts');
                Route::get('/categories','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController@categories')->name('search.categories');
                Route::get('/users','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController@categories')->name('search.users');
                Route::get('/folders','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController@folders')->name('search.folders');
                Route::get('/files','JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\SearchController@uploads')->name('search.files');
            });
        });
    });
