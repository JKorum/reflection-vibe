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
    return view('welcome');
});

Auth::routes();

Route::get('/posts/create', 'PostController@create');
Route::get('/posts/{post}', 'PostController@show');
Route::post('/posts/{post}/like', 'LikeController@store');
Route::post('/posts/{post}/comments', 'CommentController@store');
Route::get('/posts/{post}/comments', 'CommentController@show');
Route::delete('/posts/{post}/comments/{comment}', 'CommentController@delete');
Route::get('/posts/{post}/likers', 'PostController@likers');
Route::post('/posts', 'PostController@store');

Route::get('/profiles/{user}', 'ProfileController@show');
Route::get('/profiles/{user}/edit', 'ProfileController@edit')->middleware('auth');
Route::patch('/profiles/{user}', 'ProfileController@update')->middleware('auth');

Route::get('/profiles/{user}/follow', 'FollowController@toggle');
Route::get('/profiles/{user}/follow/count', 'FollowController@count');

Route::get('/home', 'HomeController@index')->name('home');
