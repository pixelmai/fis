<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\User;
use Illuminate\Http\Request;

class AppsettingsController extends Controller
{
  public function __construct()
  {
  $this->middleware('auth');
  }
  

  public function index()
  {
    $user = auth()->user();
    $appsettings = Appsettings::find(1);
    $settings_updater = User::find($appsettings->user_id);

    return view('appsettings.index', ['user' => $user, 'appsettings' => $appsettings, 'settings_updater' => $settings_updater]);
  }

  public function edit()
  {
    $user = auth()->user();
    if($user->superadmin){
      $appsettings = Appsettings::find(1);
      return view('appsettings.edit', ['user' => $user, 'appsettings' => $appsettings]);
    }else{
      return redirect("/appsettings")->with(['status' => 'danger', 'message' => 'No permission to update App Settings']);
    }
  }

  public function update()
  {
    $user = auth()->user();
    $appsettings = Appsettings::find(1);

    if($user->superadmin){

      $data = request()->validate([
        'name' => 'required',
        'manager' => 'required',
        'email' => 'email',
        'number' => ['required'],
        'address' => 'required',
        'dsc' => ['required','numeric'],
        'dpwd' => ['required','numeric'],
      ]);

      $appsettings->name = $data['name'];
      $appsettings->manager = $data['manager'];
      $appsettings->email = $data['email'];
      $appsettings->number = $data['number'];
      $appsettings->address = $data['address'];
      $appsettings->dpwd = $data['dpwd'];
      $appsettings->dsc = $data['dsc'];
      $appsettings->user_id = $user->id;

      $query = $appsettings->update();

      if($query){
        return redirect("/appsettings")->with(['status' => 'success', 'message' => 'Updated Application Settings Successfully']);
      }

    }else{
      return redirect("/appsettings")->with(['status' => 'danger', 'message' => 'No permission to update the Application Settings']);
    }

  }


  public function categories(){
    $user = auth()->user();
    if($user->superadmin){
      $cat_settings['seltab'] = 'info';
      return view('appsettings.categories.index', ['user' => $user, 'cat_settings'=> $cat_settings]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }


}