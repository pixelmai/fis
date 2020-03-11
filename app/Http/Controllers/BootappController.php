<?php

namespace App\Http\Controllers;

use App\User;
use App\Appsettings;
use App\Partners;
use App\Sectors;
use App\Servcats;
use App\Regmsmes;
use App\Regtypes;
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


    // PARTNERS LIST
    $partners = Partners::find(1);
    if(!$partners){
      Partners::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'GOV', 'description' => 'Government' ]);
      Partners::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'NGO', 'description' => 'Nonprofit Organization']);
      Partners::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Commercial']);
      $s = TRUE;
    }


    // SECTORS LIST
    $servcats = Servcats::find(1);
    if(!$servcats){
      Servcats::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Machine Use']);
      Servcats::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Tour']);
      Servcats::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Consultation']);
      $s = TRUE;
    }

    // REGISTRATION MSME LIST
    $regmsme = Regmsmes::find(1);
    if(!$regmsme){
      Regmsmes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Registered']);
      Regmsmes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Unregistered']);
      Regmsmes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Potential']);
      $s = TRUE;
    }

    // REGISTRATION TYPES LIST
    $regtypes = Regtypes::find(1);
    if(!$regmsme){
      Regtypes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'DTI','regmsmes_id' => '1']);
      Regtypes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'SEC','regmsmes_id' => '1']);
      Regtypes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'CDA','regmsmes_id' => '1']);
      Regtypes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Unregistered','regmsmes_id' => '2']);
      Regtypes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Student','regmsmes_id' => '3']);
      Regtypes::create(['is_active' => 1, 'updatedby_id' => 1, 'name' => 'Hobbyist','regmsmes_id' => '3']);
      $s = TRUE;
    }


    if($s){
      dd('Successfully setup primary database items');
    } else{
      dd('Nothing to add');
    }

  }



   
}
