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

	public function rework()
    {
        return $this->hasMany('App\Rework','vm_id');
    }

	
}


