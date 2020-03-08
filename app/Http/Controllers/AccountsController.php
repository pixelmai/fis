<?php

namespace App\Http\Controllers;

Use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

use App\Rules\PhoneNumber;
use App\Rules\MatchOldPassword;
use Hash;



class AccountsController extends Controller
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
    return view('accounts.index', compact('user'));
  }


  public function edit()
  {
    $user = auth()->user();
    $page_settings['title'] = 'Edit Profile';
    $page_settings['heading'] = TRUE;
    $page_settings['seltab'] = 'superadmin';

    return view('accounts.edit', [
      "user"=>$user, 
      "page_settings"=>$page_settings
      ]);
  }



  public function update()
  {

    $user = User::find(auth()->user()->id);


    $data = request()->validate([
      'image' => '',
      'fname' => 'required',
      'lname' => 'required',
      'email' => 'email',
      'number' => ['nullable', new PhoneNumber],
      'address' => 'nullable',
      'position' => 'required',
      'skillset' => 'nullable',
    ]);


    if(request('image')){

      $imagePath = request('image')->store('profile','public');

      $image = Image::make(public_path("storage/{$imagePath}"))->fit(800, 800);
      $image->save();
      $user->image = $imagePath;
    }

    /*
    $user->update(array_merge(
      $data,
      $imageArray ?? []
    ));
    */

    $user->fname = $data['fname'];
    $user->lname = $data['lname'];
    $user->email = $data['email'];
    $user->number = $data['number'];
    $user->address = $data['address'];
    $user->position = $data['position'];
    $user->skillset = $data['skillset'];


    $query = $user->update();

    if($query){
      return redirect("/account")->with(['status' => 'success', 'message' => 'Updated Account Successfully']);
    }

  }

  public function changePassword()
  {
    $user = auth()->user();
    return view('accounts.changePassword', compact('user'));
  }

  public function updatePassword(Request $request)
  {

    $request->validate([
        'current_password' => ['required', new MatchOldPassword],
        'new_password' => ['required','min:8'],
        'new_confirm_password' => ['same:new_password'],
    ]);

    $query = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

    if($query){
      return redirect("/account")->with(['status' => 'success', 'message' => 'Password Changed Successfully.']);
    }



  }




}
