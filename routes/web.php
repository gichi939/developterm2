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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
     Route::get('develop/create', 'Admin\DevelopController@add');
     Route::post('develop/create', 'Admin\DevelopController@create'); 
     Route::get('develop', 'Admin\DevelopController@index');
     Route::get('develop/edit', 'Admin\DevelopController@edit');
     Route::post('develop/edit', 'Admin\DevelopController@update');
     Route::get('develop/delete', 'Admin\DevelopController@delete');
     Route::get('/develop/like/{id}', 'Admin\DevelopController@like')->name('reply.like');
     Route::get('/develop/unlike/{id}', 'Admin\DevelopController@unlike')->name('reply.unlike');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
     Route::get('comment/create/{id}', 'Admin\CommentController@add');
     Route::post('comment/create', 'Admin\CommentController@create');
     Route::get('comment/delete', 'Admin\CommentController@delete');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'NewsController@index');
Route::get('/details', 'NewsController@details');
