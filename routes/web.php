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


Auth::routes();

Route::get('/ip', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('create-vm', 'VmController@index')->name('createVM');
Route::post('vm', 'VmController@store')->name('vm');;
Route::get('vm', 'VmController@show')->name('showVmLogs');
Route::get('all-vm', 'VmController@create')->name('allVM');
Route::post('vm/{id}', 'VmController@destroy')->name('deletevm');


Route::get('/', 'VmController@index')->name('home');
