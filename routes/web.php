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

    Route::group(['middleware' => ['web']], function()
    {

        Route::resource('order','\\JornSchalkwijk\LaravelCMS\Http\Controllers\OrderController')->only(['index','store']);
        Route::group(['prefix' => '/order'],function(){
            Route::get('/{order}', '\\JornSchalkwijk\LaravelCMS\Http\Controllers\OrderController@show')->name('order.show')->middleware(['auth:customer']);
            Route::get('/empty', '\\JornSchalkwijk\LaravelCMS\Http\Controllers\OrderController@empty')->name('order.empty');
            Route::get('refresh', '\\JornSchalkwijk\LaravelCMS\Http\Controllers\OrderController@refresh')->name('order.refresh');
        });

        // Authentication Routes...
        Route::get('/login', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerLoginController@showLoginForm')->name('customer.login');
        Route::post('/login', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerLoginController@login');
        Route::post('/logout', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerLoginController@logout')->name('customer.logout');
        // Registration Routes...
        Route::get('/register', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerRegisterController@showRegistrationForm');
        Route::post('/register', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerRegisterController@registerFromOrder')->name('customer.register');
        // Password Reset Routes...
        Route::get('/password/reset', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerForgotPasswordController@customer.showLinkRequestForm')->name('customer.password.request');
        Route::post('/password/email', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerForgotPasswordController@customer.sendResetLinkEmail');
        Route::post('/password/reset/{token}', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerResetPasswordController@customer.showResetForm');
        Route::post('/password/reset', '\JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth\CustomerResetPasswordController@customer.reset')->name('customer.password.request');

        Route::get('/', 'PagesController@index');

        Route::get('/about','PagesController@about');
        Route::get('/skills','PagesController@skills');

        Route::get('/blog', 'PostsController@index');
        Route::resource('post','PostsController')->only(['show']);

        Route::get('/categories', 'Categories@index');
        Route::get('/categories/{category}', 'Categories@show');

        Route::resource('cart','CartController')->only(['index']);
        Route::group(['prefix' => '/cart'],function(){
            Route::post('/add', 'CartController@add')->name('cart.add');
            Route::post('/update', 'CartController@update')->name('cart.update');
            Route::get('/{id}/destroy', 'CartController@destroy')->name('cart.destroy');
            Route::get('/empty', 'CartController@empty')->name('cart.empty');
            Route::get('refresh', 'CartController@refresh')->name('cart.refresh');
        });
    });