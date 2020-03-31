<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','description', 'url', 'status', 
    'url','client_id','updatedby_id', 
  ];


  public function client(){
    return $this->belongsTo('App\Clients');
  }




}
