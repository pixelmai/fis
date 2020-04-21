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
      'updatedby_id', 'is_deactivated', 'token'
  ];

  protected static function boot(){
    parent::boot(); 

    static::created(function ($client){
      $client->projects()->create([
        'name' => 'Uncategorized C'. $client->id,
        'status' => '1',
        'updatedby_id' => 1,
        'is_categorized' => 0,
        'is_deactivated' => 0
      ]);
      
    });
  }


  public function sector(){
    return $this->belongsTo('App\Sectors');
  }

  public function regtype(){
    return $this->belongsTo('App\Regtypes');
  }

  public function company(){
    return $this->belongsTo('App\Companies');
  }

  public function maincompany(){
    return $this->hasMany('App\Companies','client_id','id');
  }

  public function projects(){
    return $this->hasMany('App\Projects','client_id','id');
  }

  public function mainproject(){
    return $this->hasone('App\Projects','client_id','id')->where('is_categorized', 0);
  }

  public function invoices(){
    return $this->hasMany('App\Invoices','clients_id','id');
  }

}


