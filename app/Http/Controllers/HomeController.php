<?php

namespace App\Http\Controllers;
Use App\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {

    
    $user = auth()->user();
    $user->last_login = date('Y-m-d H:i:s');
    $user->update();


    $page_settings['seltab'] = 'dashboard'; 
    
    return view('home', [
      "user"=>$user, 
      "page_settings"=>$page_settings
    ]);


  }
}
