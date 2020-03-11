<?php

namespace App\Http\Controllers;

use App\User;
use App\Sectors;
use Illuminate\Http\Request;

class SectorsController extends Controller
{


  private $cat_settings;
  private $unauth;

  public function __construct()
  {
    //Page repeated defaults
    $this->cat_settings['seltab'] = 'sectors';
    $this->homeLink = '/categories';
    $this->unauth = '/home';
    $this->unauthMsg = 'No permission to Type Categories';
  }


  public function index()
  {
    $user = auth()->user();
    if($user->superadmin){

      $cat_types = Sectors::orderBy('is_active', 'DESC')->orderBy('name', 'ASC')->paginate(20);

      return view('appsettings.categories.sectors.index', ['user' => $user, 'cat_settings'=> $this->cat_settings,'cat_types'=>$cat_types]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }


  public function create()
  {
    $user = auth()->user();

    if($user->superadmin){
      return view('appsettings.categories.sectors.create', ['user' => $user, 'cat_settings'=> $this->cat_settings]);
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
    ]);

    $data['is_active'] = 1;


    $query = Sectors::create([
      'name' => $data['name'],
      'description' => $data['description'],
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
    $cat_type = Sectors::find($tid);

    if($user->superadmin && $cat_type){
      return view('appsettings.categories.sectors.edit', ['user' => $user, 'cat_type' => $cat_type, 'cat_settings'=> $this->cat_settings]);
    }else{
      return notifyRedirect($this->unauth, $this->unauthMsg, 'danger');
    }
  }

  public function update($tid)
  {

    $user = auth()->user();
    $cat_type = Sectors::find($tid);

    if($user->superadmin && $cat_type){
      $data = request()->validate([
        'name' => 'required',
        'description' => 'required',
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

 
  public function deactivate($tid)
  {
    $user = auth()->user();
    $cat_type = Sectors::find($tid);

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
    $cat_type = Sectors::find($tid);

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
