<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    
Route::get('/', function () {
    return redirect(url('/posts'));
});

Auth::routes([
    'verify' => true
]);
Route::resource('/posts', 'PostController')->except([
    'show'
]);
Route::get('/posts/{post}/{slug}', 'PostController@show');
Route::post('/contact-us', 'ContactUsController@send');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
    Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/password', 'Auth\PasswordController@getUpdate');
    Route::post('/password', 'Auth\PasswordController@postUpdate');
});




Route::prefix(config('site.admin_routes_prefix'))->group(function () {
    //Route::get('/login', 'Admin\Auth\LoginController@getLogin');
    //Route::post('/login', 'Admin\Auth\LoginController@postLogin');

    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', function () {
            return redirect(adminUrl('/posts'));
        });
        Route::post('/logout', 'Admin\Auth\LoginController@postLogout');
        Route::resource('/users', 'Admin\UserController');
        Route::patch('/users/{user}/password', 'Admin\UserController@patchPassword');
        Route::resource('/admins', 'Admin\AdminController');
        Route::resource('/posts', 'Admin\PostController');
        Route::post('/images', 'Admin\ImageController@upload');
    });

});
