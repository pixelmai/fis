<?php

namespace App\Http\Controllers;

use App\User;
use App\Appsettings;
use Illuminate\Http\Request;

class BootappController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {


    $user = User::find(1);

    if(!$user){
      User::create([
      'fname' => 'Charlotte Mae',
      'lname' => 'Efren',
      'email' => 'cursefury@gmail.com',
      'number' => '091891234567',
      'address' => 'Cebu City',
      'position' => 'UX Designer',
      'skillset' => 'UI Design, UX Design, Front-end Programming, Illustration',
      'password' => '$2y$10$0exVx6HCj.khY42bZsjMPuUtMO7n5e02/iatuv/wFMKyAgoitlGmS',
      'superadmin'=> 1,
      ]);

      $appsettings = Appsettings::find(1);

      if(!$appsettings){
        Appsettings::create([
        'name' => 'FABLAB UP Cebu',
        'address' => '6000, 168 Gorordo Ave, Cebu City, 6000 Cebu',
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
