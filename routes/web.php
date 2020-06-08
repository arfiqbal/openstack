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

// Route::get('/ip', 'HomeController@index')->name('home');
 Route::get('home', function(){
    return redirect()->route('allVM');
 });

Route::get('recreate-vm/{id}', 'VmController@vmRecreate')->name('vmRecreate');
Route::post('recreate-vm', 'VmController@update')->name('postVmRecreate');
Route::post('get-flavor', 'VmController@getFlavor')->name('getFlavor');
Route::post('change-flavor', 'VmController@changeFlavor')->name('changeFlavor');

Route::get('create-vm', 'VmController@index')->name('createVM');
Route::post('vm', 'VmController@store')->name('vm');;
Route::get('vm/{id}/{vmid}/detail', 'VmController@show')->name('showVM');
Route::get('all-vm', 'VmController@create')->name('allVM');
Route::post('vm/{id}', 'VmController@destroy')->name('deletevm');
Route::get('/', 'VmController@index')->name('home');

Route::get('add-image', 'ImageController@index')->name('addImage');
Route::post('add-image', 'ImageController@store')->name('postImage');

//Route::get('pdf', 'ImageController@pdf')->name('pdf');

Route::get('volumes', 'VolumeController@index')->name('volumes');




