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

use OpenStack\OpenStack;

Route::get('test', function () {
    $openstack_server = new OpenStack([
        'authUrl' => 'http://10.85.49.148:5000/v3/',
        'region'  => 'nova',
        'user'    => [
            'id'       => 'd348fcb1b1994c3ea5c7cea8c00a770a',
            'password' => 'ayZma3wpahjHWgpjBRQypFUYK',
            'domain' => ['name' => "default"]
        ],
        'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
    ]);
        $compute = $openstack_server->computeV2();

        $servers = $compute->listServers();
});

Route::get('test1', function () {
    
    dd('working');
});

Route::get('/', 'HomeController@index')->name('home');
