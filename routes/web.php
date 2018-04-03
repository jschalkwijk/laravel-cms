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

/* Hardcoded Routes */
Route::get('/', 'PagesController@index');

Route::get('/about','PagesController@about');
Route::get('/skills','PagesController@skills');

Route::get('/blog', 'Posts@index');
Route::get('/blog/{post}', 'Posts@show');

Route::get('/categories', 'Categories@index');
Route::get('/categories/{category}', 'Categories@show');

/* Created by user in CMS */
Route::get('/{page}', 'PagesController@show');

Auth::routes();

Route::get('/home', 'HomeController@index');

/* Backend Routes */
include_once 'partials/backend.php';