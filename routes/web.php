<?php
// if(!app()->environment('testing')) Auth::loginUsingId(2);
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


//  **--** Control Panel **--**

$locale = app()->environment('testing') ? 'ar' : Request::segment(1);

Route::middleware('language')->prefix($locale.'/control-panel')->group(function() {
Route::get('login','AuthController@index')->name('loginPage');
Route::post('login','AuthController@login')->name('login');
Route::middleware('auth')->group(function () {
Route::get('logout','AuthController@logout')->name('logout');
Route::get('/','ControlPanelController@enter')->name('control-home');
Route::patch('home','HomePage@update');
Route::get('home','HomePage@index');
Route::get('articles','ArticlesController@index');
Route::get('articles/add','ArticlesController@create');
Route::post('articles/add','ArticlesController@store');
Route::get('article/{article}/edit','ArticlesController@edit');
Route::patch('article/{article}','ArticlesController@update');
Route::delete('article/{article}','ArticlesController@destroy');
Route::get('users','UserController@index')->name('user-home');
Route::get('users/add','UserController@show');
Route::post('users/add','UserController@store');
Route::get('user/{user}/edit','UserController@edit')->name('profile');
Route::patch('user/{user}','UserController@update');
Route::delete('user/{user}','UserController@destroy');
Route::post('user/{user}/admin','UserController@admin');
});
});