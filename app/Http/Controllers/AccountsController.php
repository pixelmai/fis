<?php

namespace App\Http\Controllers;

Use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


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


  public function update()
  {

    $user = User::find(auth()->user()->id);


    $data = request()->validate([
        'image' => '',
        'fname' => 'required',
        'lname' => 'required',
        'number' => 'nullable',
        'address' => 'nullable',
        'position' => 'nullable',
        'skillset' => 'nullable',
    ]);


    if(request('image')){


        $imagePath = request('image')->store('profile','public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
        $image->save();

        $imageArray = ['image' => $imagePath];
    }

    /*
    $user->update(array_merge(
        $data,
        $imageArray ?? []
    ));
    */

    $user->fname = $data['fname'];
    $user->lname = $data['lname'];
    $user->number = $data['number'];
    $user->address = $data['address'];
    $user->position = $data['position'];
    $user->skillset = $data['skillset'];
    $user->update();



    //$user->update($data);

    return redirect("/account");

  }

}
