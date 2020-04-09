<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tools extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','status', 'model','brand', 'notes',
    'is_deactivated',
    'updatedby_id', 
  ];

  public function suppliers()
  {
    return $this->belongsToMany('App\Suppliers');
  }

  public function logs(){
    return $this->hasMany('App\Logs','tool_id','id');
  }
}
