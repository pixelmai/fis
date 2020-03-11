<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regtypes extends Model
{
	protected $guarded = [];

	protected $fillable = [
	'name', 'description', 'updatedby_id', 'regmsmes_id'
	];

  public function regmsmes(){
    return $this->belongsTo('App\Regmsmes');
  }

}
