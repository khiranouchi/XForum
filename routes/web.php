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

Route::get('/', 'TopController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// auth to forums
Route::get('/forums/{forum}/login', 'Auth\\ForumLoginController@showLoginForm')->name('forums.showLoginForm');
Route::post('/forums/login', 'Auth\\ForumLoginController@authenticate')->name('forums.authenticate');

// resource Forum
Route::resource('forums', 'Database\\ForumController');

// resource Thread
Route::post('/forums/{forum}/threads', 'Database\\ThreadController@store')->name('threads.store');
Route::get('/forums/{forum}/threads/{thread}', 'Database\\ThreadController@show')->name('threads.show');
Route::patch('/forums/{forum}/threads/{thread}', 'Database\\ThreadController@update')->name('threads.update');
Route::delete('/forums/{forum}/threads/{thread}', 'Database\\ThreadController@destroy')->name('threads.destroy');

// resource Comment
Route::post('/forums/{forum}/threads/{thread}/comments', 'Database\\CommentController@store')->name('comments.store');
Route::patch('/forums/{forum}/threads/{thread}/comments/{comment}', 'Database\\CommentController@update')->name('comments.update');
Route::delete('/forums/{forum}/threads/{thread}/comments/{comment}', 'Database\\CommentController@destroy')->name('comments.destroy');

// resource Reply
Route::post('/forums/{forum}/threads/{thread}/comments/{comment}/replies', 'Database\\ReplyController@store')->name('replies.store');
Route::patch('/forums/{forum}/threads/{thread}/comments/{comment}/replies/{reply}', 'Database\\ReplyController@update')->name('replies.update');
Route::delete('/forums/{forum}/threads/{thread}/comments/{comment}/replies/{reply}', 'Database\\ReplyController@destroy')->name('replies.destroy');
