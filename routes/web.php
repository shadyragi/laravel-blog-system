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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web']], function () {
    //
    Route::auth();

	Route::get('/home', 'HomeController@index');
    
    Route::get('/threads/create', 'ThreadController@create');


    Route::get('/threads/{channel?}', 'ThreadController@index');
  
    Route::post('/threads', 'ThreadController@store');

    Route::get('/threads/{channel}/{thread}', 'ThreadController@show');

    Route::delete('/threads/{id}', 'ThreadController@destroy');

    Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store')->name('add_reply');

    Route::delete('/replies/{reply}', 'ReplyController@destroy')->name('delete_reply');

    Route::get('replies/{reply}/edit', 'ReplyController@edit')->name('edit_reply');

    Route::put('replies/{reply}/update', 'ReplyController@update')->name('update_reply');

    Route::post('/replies/{reply}/like', 'likesController@store');

    Route::get('/', function () {
    
    return view('welcome');
});
});
