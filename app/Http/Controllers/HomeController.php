<?php

namespace App\Http\Controllers;
Use App\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {

    
    $user = auth()->user();
    //return view('home', compact('user'));
    $user->last_login = date('Y-m-d H:i:s');
    $user->update();


    $page_settings['seltab'] = 'dashboard'; //selected menu header
    //$page_settings['seltab2'] = 'clients'; //inner selected menu

    return view('home', [
      "user"=>$user, 
      "page_settings"=>$page_settings
    ]);


  }
}
