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

      $dbtable = Projects::with('client:id,fname,lname')->where('is_categorized', 1)->orderBy('updated_at', 'DESC')->get();

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
      ->addColumn('created',  '{{ dateShortOnly($created_at) }}')
      ->addColumn('updated',  '{{ dateTimeFormat($updated_at) }}')
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
        ->rawColumns(['checkbox','action','created','updated','status'])
      ->make(true);
      
    }
        
    return view('projects.index', ['user' => $user, 'page_settings'=> $this->page_settings]);

  }


  public function create()
  {
    $user = auth()->user();
    return view('projects.create', ['user' => $user, 'page_settings'=> $this->page_settings]);
  }


  public function store(Request $request)
  {

    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255', 'unique:projects'],
      'url' => ['nullable', 'string', 'max:255', new Url],
      'description' => ['nullable'],
      'client_id' => ['required'],
      'status' => ['required'],
    ]);

    $client_check = Clients::find($data['client_id']);

    if(!isset($client_check)){
      return notifyRedirect($this->homeLink, 'Client non-existent', 'danger');
    }

    $query = Projects::create([
      'name' => $data['name'],
      'url' => $data['url'],
      'description' => $data['description'],
      'client_id' => $data['client_id'],
      'status' => $data['status'],
      'is_categorized' => 1, 
      'is_deactivated' => 0, 
      'updatedby_id' => $user->id,
    ]);

    if($query){
      return notifyRedirect($this->homeLink, 'Added Project Successfully!', 'success');
    }

  }


  public function view($id)
  {
    $user = auth()->user();
    $project = Projects::with('client')->find($id);
    $updater = User::find($project->updatedby_id);

    switch ($project->status) {
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



    return view('projects.view', ['user' => $user, 'project' => $project, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s]);
  }


  public function edit($id)
  {
    $user = auth()->user();
    $project = Projects::with('client')->find($id);

    if(isset($project)){

      if($project->is_categorized == FALSE ){
        return notifyRedirect($this->homeLink, 'Project not found', 'danger');
      }

      return view('projects.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'project' => $project]);
    }else{
      return notifyRedirect($this->homeLink, 'Company not found', 'danger');
    }
    
  }


  public function update($id)
  {
    $user = auth()->user();
    $project = Projects::find($id);

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'url' => ['nullable', 'string', 'max:255', new Url],
      'description' => ['nullable'],
      'client_id' => ['required'],
      'status' => ['required'],
    ]);


    if($project->name != $data['name']){
      $name = request()->validate([
        'name' => ['required', 'string', 'max:255', 'unique:projects']
      ]);

      $project->name = $data['name'];
    }

    $project->url = $data['url'];
    $project->description = $data['description'];
    $project->client_id = $data['client_id'];
    $project->status = $data['status'];
    $project->updatedby_id = $user->id;

    $query = $project->update();

    if($query){
      return notifyRedirect('/projects/view/'.$id, 'Updated project '. $project->name .' successfully', 'success');
    }

  }

  public function destroy($id)
  {

    $project = Projects::find($id);
    if($project){
      if(request()->ajax()){
        $row = Projects::where('id',$id)->delete();
        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Project not found', 'danger');
    }
  }



  public function status(Request $request)
  {
    if(request()->ajax()){
      
      $row_id_array = $request->input('id');
      $form = $request->input('formData');

      $count_updated = 0;

      foreach ($row_id_array as $row) {
          $row = Projects::find($row); 
          $row->status = $form['status'];
          $row->updatedby_id = $form['updatedby_id'];
          $query = $row->update();
          $count_updated++;
      }

      return Response::json($count_updated);

    }else{
      return notifyRedirect($this->homeLink, 'Deletion action not permitted', 'danger');
    }
  }


}
