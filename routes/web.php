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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'TwitterController@home');

Route::get('/login', 'TwitterController@login')->name('twitter.login');
Route::get('/callback', 'TwitterController@callback')->name('twitter.callback');

Route::get('twitter/error', ['as' => 'twitter.error', function(){
    // Something went wrong, add your own error handling here
}]);

Route::get('twitter/logout', ['as' => 'twitter.logout', function(){
    Session::forget('access_token');
    return Redirect::to('/')->with('flash_notice', 'You\'ve successfully logged out!');
}]);
