<?php

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Companies;
use App\Partners;
use App\Rules\Url;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

class CompaniesController extends Controller
{
  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'customers';
    $this->page_settings['seltab2'] = 'companies';
    $this->homeLink = '/companies';
  }

  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      //'id','name','email','number','partner_id','client_id'
      $dbtable = Companies::with('partner:id,name', 'contactperson:id,fname,lname')->where('id', '!=' , 1)->select();

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/companies/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/companies/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';
      $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
        ->rawColumns(['checkbox','action'])

      ->make(true);
      
    }
        
    return view('companies.index', ['user' => $user, 'page_settings'=> $this->page_settings]);

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
   * @param  \App\Companies  $companies
   * @return \Illuminate\Http\Response
   */
  public function show(Companies $companies)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Companies  $companies
   * @return \Illuminate\Http\Response
   */
  public function edit(Companies $companies)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Companies  $companies
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Companies $companies)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Companies  $companies
   * @return \Illuminate\Http\Response
   */
  public function destroy(Companies $companies)
  {
    //
  }


  public function dblist()
  {
    /*
    $clients = DB::table('clients')->select('*');
    return datatables()->of($clients)
        ->make(true);
    */

    $clients = Companies::with('partner:id,name', 'contactperson:id,fname,lname')->where('id', '!=' , 1)->get();

      $db= datatables()->of($clients)->make(true);
      print "<pre>";
      print_r($db);
      print "</pre>";
  }


}