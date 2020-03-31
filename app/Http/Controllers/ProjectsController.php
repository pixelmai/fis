<?php

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Projects;
use App\Rules\Url;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

class ProjectsController extends Controller
{
  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'customers';
    $this->page_settings['seltab2'] = 'projects';
    $this->homeLink = '/projects';
  }    

  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      //'id','name','email','number','partner_id','client_id'
      $dbtable = Projects::with('client:id,fname,lname')->orderBy('updated_at', 'DESC')->select();

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/projects/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/projects/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';
      $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
      return $button;
      })
      ->addColumn('status',  function($data){
        switch ($data->status) {
          case 1:
            $s = 'Open';
            break;
          case 2:
            $s = 'Completed';
            break;
          case 3:
            $s = 'Dropped';
            break;
        }
        return $s;
      })
      ->addColumn('created',  '{{ dateTimeFormat($created_at) }}')
      ->addColumn('updated',  '{{ dateTimeFormat($updated_at) }}')
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')

        ->rawColumns(['checkbox','action','created','updated','status'])

      ->make(true);
      
    }
        
    return view('projects.index', ['user' => $user, 'page_settings'=> $this->page_settings]);

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
   * @param  \App\Projects  $projects
   * @return \Illuminate\Http\Response
   */
  public function show(Projects $projects)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Projects  $projects
   * @return \Illuminate\Http\Response
   */
  public function edit(Projects $projects)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Projects  $projects
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Projects $projects)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Projects  $projects
   * @return \Illuminate\Http\Response
   */
  public function destroy(Projects $projects)
  {
    //
  }
}
