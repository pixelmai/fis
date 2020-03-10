<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\User;
use Illuminate\Http\Request;
use App\Rules\PhoneNumber;

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
        'number' => ['required', new PhoneNumber],
        'address' => 'required',
      ]);

      $appsettings->name = $data['name'];
      $appsettings->manager = $data['manager'];
      $appsettings->email = $data['email'];
      $appsettings->number = $data['number'];
      $appsettings->address = $data['address'];
      $appsettings->user_id = $user->id;

      $query = $appsettings->update();

      if($query){
        return redirect("/appsettings")->with(['status' => 'success', 'message' => 'Updated Application Settings Successfully']);
      }

    }else{
      return redirect("/appsettings")->with(['status' => 'danger', 'message' => 'No permission to update the Application Settings']);
    }

  }

}