<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name','email', 'number', 'address', 'url',
    'description', 'partner_id', 'client_id',
    'is_partner','updatedby_id', 
  ];

  public function partner(){
    return $this->belongsTo('App\Partners');
  }

  public function clients(){
    return $this->hasMany('App\Clients','company_id');
  }

  public function contactperson(){
    return $this->hasOne('App\Clients','id','client_id');
  }

}