<?php

namespace App\Http\Controllers;

use App\User;
use App\Appsettings;
use Illuminate\Http\Request;

class BootappController extends Controller
{

  public function index()
  {


    $user = User::find(1);

    if(!$user){
      User::create([
      'fname' => 'Charlotte Mae',
      'lname' => 'Efren',
      'email' => 'cursefury@gmail.com',
      'position' => 'UX Designer',
      'password' => '$2y$10$0exVx6HCj.khY42bZsjMPuUtMO7n5e02/iatuv/wFMKyAgoitlGmS',
      'superadmin'=> 1,
      ]);

      $appsettings = Appsettings::find(1);

      if(!$appsettings){
        Appsettings::create([
        'name' => 'FABLAB UP Cebu',
        'address' => 'Undergraduate Bldg., University of the Philippines Cebu, Gorordo Ave., Lahug, Cebu City 6000',
        'number' => '(032) 232 8187',
        'email' => 'fablab.upcebu@up.edu.ph',
        'manager' => 'Fidel Ricafranca',
        'user_id' => 1,
        ]);
      }


      dd('Successfully setup primary database items');

    }



  }

   
}
