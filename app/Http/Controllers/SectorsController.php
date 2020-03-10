<?php

namespace App\Http\Controllers;

use App\User;
use App\Sectors;
use Illuminate\Http\Request;

class SectorsController extends Controller
{


  public function index()
  {
    $user = auth()->user();
    if($user->superadmin){
      $cat_settings['seltab'] = 'sectors';
      $cat_types = Sectors::orderBy('is_active', 'DESC')->orderBy('name', 'ASC')->paginate(20);

      return view('appsettings.categories.index', ['user' => $user, 'cat_settings'=> $cat_settings,'cat_types'=>$cat_types]);
    }else{
      return redirect("/home")->with(['status' => 'danger', 'message' => 'No permission to edit types']);
    }
  }


  public function create()
  {
    $user = auth()->user();
    $cat_settings['seltab'] = 'sectors';

    if($user->superadmin){
      return view('appsettings.categories.create', ['user' => $user, 'cat_settings'=> $cat_settings]);
    }else{
      return redirect("/home")->with(['status' => 'danger', 'message' => 'No permission to edit types']);
    }

  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    $user = auth()->user();

    if(!$user->superadmin){
      return redirect("/team")->with(['status' => 'danger', 'message' => 'No permission to create data types']);
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
      return redirect("/categories")->with(['status' => 'success', 'message' => 'Created Type Successfully']);
    }



  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Sectors  $sectors
   * @return \Illuminate\Http\Response
   */
  public function show(Sectors $sectors)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Sectors  $sectors
   * @return \Illuminate\Http\Response
   */
  public function edit(Sectors $sectors)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Sectors  $sectors
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Sectors $sectors)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Sectors  $sectors
   * @return \Illuminate\Http\Response
   */
  public function destroy(Sectors $sectors)
  {
    //
  }
}
