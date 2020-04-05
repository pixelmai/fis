<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
  protected $guarded = [];

  protected $fillable = [
  'status', 'notes', 'updatedby_id', 'tool_id','machine_id'
  ];

  public function tool(){
    return $this->belongsTo('App\Tools','log_id','id');
  }

   public function updater(){
    return $this->belongsTo('App\User','updatedby_id','id');
  }

}
