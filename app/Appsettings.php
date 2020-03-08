<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Appsettings extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name', 'address', 'number', 'email', 'manager','user_id'
  ];


}
