<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
	protected $guarded = [];

	protected $fillable = [
	'name', 'description', 'updatedby_id', 
	];

	public function companies(){
		return $this->hasMany('App\Companies');
	}

}
