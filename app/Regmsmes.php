<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regmsmes extends Model
{
	protected $guarded = [];

	protected $fillable = [
	'name', 'description', 'updatedby_id', 
	];
}
