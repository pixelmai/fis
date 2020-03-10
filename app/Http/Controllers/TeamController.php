<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use App\Rules\PhoneNumber;
use App\Rules\MatchOldPassword;
use Hash;


class TeamController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }
  
  public function index(){
    //$posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get();
    $user = auth()->user();

    if($user->superadmin){
      $team = User::orderBy('superadmin', 'DESC')->orderBy('is_active', 'DESC')->orderBy('superadmin', 'DESC')->orderBy('id','ASC')->paginate(10);
    }else{
      $team = User::where('is_active', TRUE)->orderBy('superadmin', 'DESC')->orderBy('id','ASC')->paginate(10);
    }
  

    return view('team.index', ['user' => $user, 'team' => $team]);
  }


  public function profile($tm){

    $user = auth()->user();
    $team_member = User::find($tm);

    if($user->id != $team_member->id){
      return view('team.profile', ['user' => $user, 'team_member' => $team_member]);
    }else{
      return redirect("/account");
    }
  }

  public function create()
  {
    $user = auth()->user();

    if($user->superadmin){
      return view('team.create', compact('user'));
    }else{
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to edit user']);
    }

  }

  public function store(Request $request)
  {
    $user = auth()->user();

    if(!$user->superadmin){
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to create team members']);
    }

    $data = request()->validate([
      'fname' => ['required', 'string', 'max:255'],
      'lname' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'position' => ['required', 'string', 'max:255'],
    ]);

    
    if(isset($request['superadmin']) && $request['superadmin'] == 1){
      $data['superadmin'] = TRUE;
    }else{
      $data['superadmin'] = FALSE;
    }
  
    $data['password'] = Hash::make($data['password']);


    $query = auth()->user()->create([
      'fname' => $data['fname'],
      'lname' => $data['lname'],
      'email' => $data['email'],
      'password' => $data['password'],
      'position' => $data['position'],
      'superadmin' => $data['superadmin'],
    ]);


    if($query){
      return redirect("/team")->with(['status' => 'success', 'message' => 'Created Team Member Successfully']);
    }

  }

  public function edit($tm)
  {
    $user = auth()->user();
    $team_member = User::find($tm);


    if($user->id == $team_member->id){
      return redirect("/account");
    }


    if($this->canUpdate($team_member)){
      return view('team.edit', ['user' => $user, 'team_member' => $team_member]);
    }else{
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to edit user']);
    }
  }

  public function update($uid)
  {
    $user = User::find(auth()->user()->id);
    $team_member = User::find($uid);


    if($this->canUpdate($team_member)){

      $data = request()->validate([
        'image' => '',
        'fname' => 'required',
        'lname' => 'required',
        'email' => 'email',
        'number' => ['nullable', new PhoneNumber],
        'address' => 'nullable',
        'position' => 'required',
        'skillset' => 'nullable',
        'setadmin' => 'nullable',
        'deactivate' => 'nullable',
      ]);


      if(request('image')){

        $imagePath = request('image')->store('profile','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(800, 800);
        $image->save();
        $team_member->image = $imagePath;
      }

      $team_member->fname = $data['fname'];
      $team_member->lname = $data['lname'];
      $team_member->email = $data['email'];
      $team_member->number = $data['number'];
      $team_member->address = $data['address'];
      $team_member->position = $data['position'];
      $team_member->skillset = $data['skillset'];

      if($team_member->id != 1){
        if(isset($data['setadmin']) && $data['setadmin'] == 1){
          $team_member->superadmin = 1;
        }else{
          $team_member->superadmin = 0;
        }

        if(isset($data['deactivate']) && $data['deactivate'] == 1){
          $team_member->is_active = 0;
        }else{
          $team_member->is_active = 1;
        }
      }


      $query = $team_member->update();

      if($query){
        return redirect("/team")->with(['status' => 'success', 'message' => 'Updated Account Successfully']);
      }
    }else{
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to edit user']);
    }

  }


  public function activate($uid)
  {
    $user = User::find(auth()->user()->id);
    $team_member = User::find($uid);

    if($this->canUpdate($team_member)){

      if($team_member->id != 1){
        $team_member->is_active = 1; 
      }

      $query = $team_member->update();

      if($query){
        return redirect("/team")->with(['status' => 'success', 'message' => 'User Account has been Activated']);
      }
    }else{
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to edit user']);
    }
  }


  public function deactivate($uid)
  {
    $user = User::find(auth()->user()->id);
    $team_member = User::find($uid);

    if($this->canUpdate($team_member)){

      if($team_member->id != 1){
        $team_member->is_active = 0; 
        $team_member->superadmin = 0; 
      }

      $query = $team_member->update();

      if($query){
        return redirect("/team")->with(['status' => 'success', 'message' => 'User Account has been Deactivated']);
      }
    }else{
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to edit user']);
    }
  }


  public function canUpdate(User $tm){
    $user = auth()->user();
    $result = false;
    if($user->superadmin){
      if($tm->id != 1){ //checks if number 1 admin
        $result = true;
      }elseif ($tm->id == 1 && $user->id == 1) {
        $result = true;
      }
    }
    return $result;
  }
}
