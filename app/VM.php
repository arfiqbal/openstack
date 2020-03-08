<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VM extends Model
{
    protected $table = 'vm';

    public function application()
	{
	    return $this->belongsTo('App\Application','application_id');
	}

	public function ips()
	{
	    return $this->belongsTo('App\IPs','ip_id');
	}
}


