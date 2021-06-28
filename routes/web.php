<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Status routes
Route::get('/statuses', 'StatusesController@index')->name('statuses.index');
Route::post('/statuses', 'StatusesController@store')->name('statuses.store')->middleware('auth');

// Status like routes
Route::post('statuses/{status}/likes', 'StatusLikeController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikeController@destroy')->name('statuses.likes.destroy')->middleware('auth');

// Comments status route
Route::post('status/{status}/comment', 'CommentController@store')->name('status.comment.store')->middleware('auth');

// Commants like route
Route::post('comments/{comment}/likes', 'CommentLikesController@store')->name('comment.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentLikesController@destroy')->name('comment.likes.destroy')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
