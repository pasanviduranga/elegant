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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/friends', 'FriendController@index')->middleware('verified');;
Route::get('/friends/search', 'FriendController@search')->middleware('verified');;
Route::delete('/friends/{friend}', 'FriendController@destroy')->middleware('verified');;
Route::get('/friends/invite', 'FriendController@invite')->middleware('verified');;
Route::post('/friends/invite', 'FriendController@store')->middleware('verified');;
Route::get('/friends/accept/{friend}', 'FriendController@update');
