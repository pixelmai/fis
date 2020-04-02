<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','status', 'notes',
    'is_available','is_deactivated',
    'updatedby_id', 
  ];

  public function suppliers()
  {
    return $this->belongsToMany('App\Suppliers');
  }
}
