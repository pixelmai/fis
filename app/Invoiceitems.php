<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoiceitems extends Model
{

  protected $fillable = [
    'invoices_id','quantity', 'services_id', 'servicesrates_id', 'machines_id',
  ];

  public function invoice(){
    return $this->belongsTo('App\Invoices');
  }

  public function service(){
    return $this->hasOne('App\Services');
  }

  public function rate(){
    return $this->hasOne('App\Servicesrates');
  }

  public function machine(){
    return $this->hasOne('App\Machines');
  }
  
}
