<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'equipment';
    $this->page_settings['seltab2'] = 'suppliers';
    $this->homeLink = '/suppliers';
  }    

  
  /*

  'name','email', 'number', 'address', 'url',
  'contact_person', 'specialty', 'supplies',
  'is_deactivated','updatedby_id', 

  */
  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      $dbtable = Suppliers::where('is_deactivated', 0)->orderBy('updated_at', 'DESC')->select();

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/projects/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/projects/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';
      $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
        ->rawColumns(['checkbox','action'])
      ->make(true);
      
    }
        
    return view('suppliers.index', ['user' => $user, 'page_settings'=> $this->page_settings]);


  }


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
   * @param  \App\Suppliers  $suppliers
   * @return \Illuminate\Http\Response
   */
  public function show(Suppliers $suppliers)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Suppliers  $suppliers
   * @return \Illuminate\Http\Response
   */
  public function edit(Suppliers $suppliers)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Suppliers  $suppliers
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Suppliers $suppliers)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Suppliers  $suppliers
   * @return \Illuminate\Http\Response
   */
  public function destroy(Suppliers $suppliers)
  {
    //
  }
}
