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

	public function network()
	{
	    return $this->belongsTo('App\Network','network_id');
	}

	public function network1()
	{
	    return $this->belongsTo('App\Network1','network1_id');
	}

	
}


