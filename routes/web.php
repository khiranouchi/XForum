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

Route::resource('forums', 'Database\\ForumController');
Route::resource('threads', 'Database\\ThreadController');
Route::resource('comments', 'Database\\CommentController');
Route::resource('replies', 'Database\\ReplyController');
