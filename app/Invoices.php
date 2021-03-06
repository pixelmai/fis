<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{

  protected $fillable = [
    'clients_id','companies_id', 'projects_id', 'status','is_up', 'discount',
    'discount_type', 'subtotal', 'jobs', 'total', 'due_date',
    'updatedby_id','is_saved','created_at','token'
  ];

  public function client(){
    return $this->belongsTo('App\Clients','clients_id','id');
  }

  public function company(){
    return $this->belongsTo('App\Companies','companies_id','id');
  }

  public function project(){
    return $this->belongsTo('App\Projects','projects_id','id');
  }

  public function items(){
    return $this->hasMany('App\Invoiceitems');
  }

}
