<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
  protected $guarded = [];

  protected $fillable = [
      'fname', 'lname', 'email', 'gender','registration_id','sector_id',
      'date_of_birth', 'number', 'address', 'position','url','skillset', 
      'hobbies', 'company_id','is_pwd','is_freelancer','is_food',
      'updatedby_id', 
  ];
  
}


