<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicesrates extends Model
{
	protected $guarded = [];


	protected $fillable = [
		'services_id', 'def_price', 'up_price', 'updatedby_id',
	];

	public function services(){
		return $this->belongsTo('App\Services');
	}
}
