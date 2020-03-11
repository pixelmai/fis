<?php

namespace App\Http\Controllers;

use App\User;
use App\Appsettings;
use App\Sectors;
use App\Partners;
use Illuminate\Http\Request;

class BootappController extends Controller
{

  public function index()
  {
    $s = FALSE;
    // PRIMARY ADMIN CREATION

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

      $s = TRUE;
    }

    // APP SETTING DEFAULTS
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

      $s = TRUE;
    }


    // SECTORS LIST
    $sectors = Sectors::find(1);
    if(!$sectors){
      Sectors::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Creative']);
      Sectors::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Furniture']);
      Sectors::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'GDH', 'description' => 'Gifts, Décor, and Houseware industry']);
      Sectors::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Wearables']);
      Sectors::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Food']);
      Sectors::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Others']);

      $s = TRUE;
    }


    // SECTORS LIST
    $partners = Partners::find(1);
    if(!$partners){
      Partners::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'GOV', 'description' => 'Government' ]);
      Partners::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'NGO', 'description' => 'Nonprofit Organization']);
      Partners::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Commercial']);
      $s = TRUE;
    }


    if($s){
      dd('Successfully setup primary database items');
    } else{
      dd('Nothing to add');
    }
    
  }



   
}
