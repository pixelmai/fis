<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//use Illuminate\Support\Facades\Mail;
//use App\Mail\NewUserWelcomeMail;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'fname', 'lname', 'email', 'password','position','superadmin'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'email_verified_at' => 'datetime',
  ];

  protected static function boot(){
    parent::boot(); 

    /*
    static::created(function ($user){
      $user->profile()->create([
        'title' => $user->username,
      ]);

      Mail::to($user->email)->send(new newUserWelcomeMail());

    });

    */



  }

  public function profileImage(){
    $imagePath = ($this->image) ? '/storage/' . $this->image : '/images/no_profile.png';
    return $imagePath;
  }


}

