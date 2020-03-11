<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectors extends Model
{
    //
	protected $guarded = [];

	protected $fillable = [
	'name', 'description', 'updatedby_id', 
	];
}
