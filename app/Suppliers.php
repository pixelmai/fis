<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','email', 'number', 'address', 'url',
    'contact_person', 'specialty', 'supplies',
    'is_deactivated','updatedby_id', 
  ];

  public function tools()
  {
    return $this->belongsToMany('App\Tools');
  }

}
