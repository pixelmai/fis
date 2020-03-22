<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
  protected $guarded = [];

  protected $fillable = [
      'fname', 'lname', 'email', 'gender','regtype_id','sector_id',
      'date_of_birth', 'number', 'address', 'position','url','skillset', 
      'hobbies', 'company_id','is_pwd','is_freelancer','is_food',
      'updatedby_id', 
  ];

  public function sector(){
    return $this->belongsTo('App\Sectors');
  }

  public function regtype(){
    return $this->belongsTo('App\Regtypes');
  }

  public function company(){
    return $this->belongsTo('App\Companies');
  }

}


