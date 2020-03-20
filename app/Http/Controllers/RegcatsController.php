<?php

namespace App\Http\Controllers;

use App\User;
use App\Regmsmes;
use App\Regtypes;
use Illuminate\Http\Request;

class RegcatsController extends Controller
{
  private $cat_settings;
  private $unauth;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->cat_settings['seltab'] = 'registrations';
    $this->homeLink = '/categories/registrations';
    $this->unauth = '/home';
    $this->unauthMsg = 'No permission to Type Categories';
  }

  public function index()
  {
    $user = auth()->user();
    if($user->superadmin){

      $cat_types = Regtypes::with('regmsmes')->orderBy('is_active', 'DESC')->orderBy('id', 'ASC')->paginate(20);

      $msme_types = Regmsmes::orderBy('is_active', 'DESC')->orderBy('id', 'ASC')->paginate(20);

      return view('appsettings.categories.registrations.index', ['user' => $user, 'cat_settings'=> $this->cat_settings,'cat_types'=>$cat_types, 'msme_types'=> $msme_types]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }



  public function create()
  {
    $user = auth()->user();

    if($user->superadmin){


      $msme_types = Regmsmes::where('is_active', '1')->get();

      return view('appsettings.categories.registrations.create', ['user' => $user, 'cat_settings'=> $this->cat_settings, 'msme_types' => $msme_types]);


    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }

  }

  public function store(Request $request)
  {

    $user = auth()->user();

    if(!$user->superadmin){
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'msme_types' => ['required'],
    ]);

    $query = Regtypes::create([
      'name' => $data['name'],
      'description' => $data['description'],
      'regmsmes_id' => $data['msme_types'],
      'is_active' => 1,
      'updatedby_id' => $user->id,
    ]);


    if($query){
      return notifyRedirect($this->homeLink, 'Added a type category successfully', 'success');
    }

  }

  public function edit($tid)
  {
    $user = auth()->user();
    $cat_type = Regtypes::find($tid);

    $msme_types = Regmsmes::where('is_active', '1')->get();

    if($user->superadmin && $cat_type){
      return view('appsettings.categories.registrations.edit', ['user' => $user, 'cat_type' => $cat_type, 'cat_settings'=> $this->cat_settings, 'msme_types' => $msme_types]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }

  public function update($tid)
  {

    $user = auth()->user();
    $cat_type = Regtypes::find($tid);

    if($user->superadmin && $cat_type){
      $data = request()->validate([
        'name' => 'required',
        'description' => 'nullable',
        'msme_types' => 'required',
      ]);

      $cat_type->name = $data['name'];
      $cat_type->description = $data['description'];
      $cat_type->regmsmes_id = $data['msme_types'];
      
      $query = $cat_type->update();

      if($query){
        return notifyRedirect($this->homeLink, 'Updated '. $cat_type->name .' type successfully', 'success');
      }

    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }

  }

 
  public function deactivate($tid)
  {
    $user = auth()->user();
    $cat_type = Regtypes::find($tid);

    if($user->superadmin && $cat_type){

      $cat_type->is_active = 0;
      $query = $cat_type->update();

      if($query){
        return notifyRedirect($this->homeLink, 'Deactivated '. $cat_type->name .' type successfully', 'success');
      }

    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }

  public function activate($tid)
  {
    $user = auth()->user();
    $cat_type = Regtypes::find($tid);

    if($user->superadmin && $cat_type){

      $cat_type->is_active = 1;
      $query = $cat_type->update();

      if($query){
        return notifyRedirect($this->homeLink, 'Activated '. $cat_type->name .' type successfully', 'success');
      }

    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }

  public function msmecreate()
  {
    $user = auth()->user();

    if($user->superadmin){
      return view('appsettings.categories.registrations.msmecreate', ['user' => $user, 'cat_settings'=> $this->cat_settings]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }

  }

  public function msmestore(Request $request)
  {

    $user = auth()->user();

    if(!$user->superadmin){
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
    ]);

    $query = Regmsmes::create([
      'name' => $data['name'],
      'description' => $data['description'],
      'is_active' => 1,
      'updatedby_id' => $user->id,
    ]);


    if($query){
      return notifyRedirect($this->homeLink, 'Added a type category successfully', 'success');
    }

  }

  public function msmeedit($tid)
  {
    $user = auth()->user();
    $cat_type = Regmsmes::find($tid);

    if($user->superadmin && $cat_type){
      return view('appsettings.categories.registrations.msmeedit', ['user' => $user, 'cat_type' => $cat_type, 'cat_settings'=> $this->cat_settings]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }

  public function msmeupdate($tid)
  {

    $user = auth()->user();
    $cat_type = Regmsmes::find($tid);

    if($user->superadmin && $cat_type){
      $data = request()->validate([
        'name' => 'required',
        'description' => 'nullable',
      ]);

      $cat_type->name = $data['name'];
      $cat_type->description = $data['description'];
      
      $query = $cat_type->update();

      if($query){
        return notifyRedirect($this->homeLink, 'Updated '. $cat_type->name .' type successfully', 'success');
      }

    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }

  }

 
  public function msmedeactivate($tid)
  {
    $user = auth()->user();
    $cat_type = Regmsmes::find($tid);

    if($user->superadmin && $cat_type){

      $cat_type->is_active = 0;
      $query = $cat_type->update();

      if($query){
        return notifyRedirect($this->homeLink, 'Deactivated '. $cat_type->name .' type successfully', 'success');
      }

    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }

  public function msmeactivate($tid)
  {
    $user = auth()->user();
    $cat_type = Regmsmes::find($tid);

    if($user->superadmin && $cat_type){

      $cat_type->is_active = 1;
      $query = $cat_type->update();

      if($query){
        return notifyRedirect($this->homeLink, 'Activated '. $cat_type->name .' type successfully', 'success');
      }

    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }
}
