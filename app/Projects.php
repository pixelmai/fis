<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','description', 'url', 'status', 'url','client_id', 
    'is_categorized', 'updatedby_id', 'is_deactivated'
  ];


  public function client(){
    return $this->belongsTo('App\Clients');
  }

  public function invoice(){
    return $this->belongsTo('App\Invoices');
  }

}
