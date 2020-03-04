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
use Illuminate\Support\Collection;
use IPv4\SubnetCalculator;


Route::get('test', function () {

    

    $data = [
        [
            'name' => 'John Doe',
            'emails' => [
                'john@doe.com',
                'john.doe@example.com',
            ],
            'contacts' => [
                [
                    'name' => 'Richard Tea',
                    'emails' => [
                        'richard.tea@example.com',
                    ],
                ],
                [
                    'name' => 'Fergus Douchebag', // Ya, this was randomly generated for me :)
                    'emails' => [
                        'fergus@douchebag.com',
                    ],
                ],
            ],
        ],
    ];
    
    $collection = collect($data);

    $collection->each(function ($item, $key) {
        //var_dump($key);
        collect($item)->each(function ($itm, $ky){
            //var_dump($itm);
            var_dump($ky);
        });
    });

    dd($collection);

    $openstack_server = new OpenStack([
        'authUrl' => 'http://10.85.49.148:5000/v3/',
        'region'  => 'regionOne',
        'user'    => [
            'id'       => 'd348fcb1b1994c3ea5c7cea8c00a770a',
            'password' => 'ayZma3wpahjHWgpjBRQypFUYK',
            'domain' => ['name' => "default"]
        ],
        'scope'   => ['project' => ['id' => '4d9031e2761c482e873ee7fcdf73ba29']]
    ]);
        $compute = $openstack_server->computeV2(['region' => 'regionOne']);

        $servers = $compute->listServers(true);

        
        
        foreach ($servers as $server) {
            
            $newCollection = new Collection($server->listAddresses());
            dd($newCollection);
            //dd($newCollection->nr_provider);
            // foreach($server->listAddresses() as $ips){
            //     $newCollection = new Collection(ips);
            //     dd($newCollection);
            // }
        }

        
});

Route::get('test1', function () {
    
    dd('working');
});

Route::get('/', 'HomeController@index')->name('home');
