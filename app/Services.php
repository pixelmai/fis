<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
	protected $guarded = [];

	protected $fillable = [
		'name', 'unit', 'servcats_id', 'servicesrates_id',
		'machines_id', 'is_deactivated', 'updatedby_id',
	];

	public function category(){
		return $this->belongsTo('App\Servcats','servcats_id','id');
	}

	public function rates(){
		return $this->hasMany('App\Servicesrates');
	}

	public function current(){
		return $this->hasOne('App\Servicesrates','id','servicesrates_id');
	}

	public function machines()
	{
	return $this->belongsToMany('App\Machines');
	}


}
