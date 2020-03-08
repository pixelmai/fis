<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\User;
use Illuminate\Http\Request;
use App\Rules\PhoneNumber;

class AppsettingsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function __construct()
  {
  $this->middleware('auth');
  }
  

  public function index()
  {
    //
    $user = auth()->user();
    $appsettings = Appsettings::find(1);

    if(!$appsettings){
      Appsettings::create([
        'name' => 'FABLAB UP Cebu',
        'address' => '6000, 168 Gorordo Ave, Cebu City, 6000 Cebu',
        'number' => '(032) 232 8187',
        'email' => 'fablab.upcebu@up.edu.ph',
        'manager' => 'Fidel Ricafranca',
        'user_id' => $user->id,
      ]);
    }

    $appsettings = Appsettings::find(1);

    $settings_updater = User::find($appsettings->user_id);

    return view('appsettings.index', ['user' => $user, 'appsettings' => $appsettings, 'settings_updater' => $settings_updater]);

  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Appsettings  $appsettings
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    //
    $user = auth()->user();
    $appsettings = Appsettings::find(1);

    return view('appsettings.edit', ['user' => $user, 'appsettings' => $appsettings]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Appsettings  $appsettings
   * @return \Illuminate\Http\Response
   */
  public function update()
  {
    //
    $user = auth()->user();
    $appsettings = Appsettings::find(1);

    if($user->superadmin){
      


      $data = request()->validate([
        'name' => 'required',
        'manager' => 'required',
        'email' => 'email',
        'number' => ['nullable', new PhoneNumber],
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
      return redirect("/appsettings")->with(['status' => 'danger', 'message' => 'No permission to update App Settings']);
    }

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Appsettings  $appsettings
   * @return \Illuminate\Http\Response
   */
  public function destroy(Appsettings $appsettings)
  {
    //
  }
}
