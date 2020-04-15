<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rework extends Model
{
    protected $table = 'rework';

    public function vm() {
		return $this->belongsTo('App\VM', 'vm_id');
	}

	
}


