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

Route::group(['middleware'=> ['web']], function (){
    // Authentication Routes...
    $this->get('/admin/login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('/admin/login', 'Auth\LoginController@login');
    $this->post('/admin/logout', 'Auth\LoginController@logout')->name('logout');
    // Registration Routes...
//    $this->get('register', 'Auth\RegisterController@showRegistrationForm');
//    $this->post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...
    $this->get('/admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('/admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('/admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    $this->post('/admin/password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/posts','Admin\PostsController@index');
    Route::get('/admin/posts/edit/{post}/{title}','Admin\PostsController@edit');
    Route::patch('/admin/posts/update/{post}/{title}','Admin\PostsController@update');
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


