<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servcats extends Model
{
	protected $guarded = [];

	protected $fillable = [
	'name', 'description', 'updatedby_id', 
	];

	public function rates(){
		return $this->hasMany('App\Services');
	}

}
