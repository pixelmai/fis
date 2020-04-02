<?php

namespace App\Http\Controllers;
use App\User;
use App\Suppliers;
use App\Tools;
use Illuminate\Http\Request;

class ToolsController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'equipment';
    $this->page_settings['seltab2'] = 'tools';
    $this->homeLink = '/tools';
  }


  public function index()
  {
    /* SIMPLE ADD 
      $user = auth()->user();
      $tool = new Tools;
      $tool->name = 'God of War';
      $tool->updatedby_id = $user->id;
      $tool->save();
      $supplier = Suppliers::find([2, 3]); //suppliers 2 and 3
      $tool->suppliers()->attach($supplier);
      return 'Success';
    */


  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function view($id)
  {
    $tools = Tools::find($id);
    return view('tools.index', compact('tools'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function edit(Tools $tools)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Tools $tools)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tools $tools)
  {
    //
  }
}
