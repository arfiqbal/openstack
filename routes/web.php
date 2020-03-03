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

Route::get('test', function () {
    $openstack = new OpenStack\OpenStack ([
        'authUrl' =>'http://10.85.49.148:5000/v2/',
        'region' =>'{region}',
        'user' =>[
            'id' =>'{userId}',
            'password' =>'{password}'
        ],
        'scope' =>['project' =>['id' =>'{projectId}']]
    ]);
    $service = $openstack->objectStoreV1 ();
    dd ($service->listContainers ());
});

Route::get('/', 'HomeController@index')->name('home');
