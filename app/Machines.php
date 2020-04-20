<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machines extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','status', 'model','brand', 'dimensions', 'notes',
    'is_deactivated', 'updatedby_id', 
  ];

  public function suppliers()
  {
    return $this->belongsToMany('App\Suppliers');
  }

  public function logs(){
    return $this->hasMany('App\Logs','machine_id','id');
  }

  public function services()
  {
    return $this->belongsToMany('App\Services');
  }



}
