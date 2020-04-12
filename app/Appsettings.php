<?php

namespace App;
use App\Appsettings;
use App\User;

use Illuminate\Database\Eloquent\Model;


class Appsettings extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'name', 'address', 'number', 'email', 'manager', 'dpwd','dsc','user_id'
  ];


}
