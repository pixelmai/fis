<?php

// TODO: Must implement Disable/Delete swaps when invoices are ready

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Invoices;
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

    $this->status = array( 
      '1' => 'Open', 
      '2' => 'Completed',
      '3' => 'Dropped'
    );

  }    

  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);

      if($active_status == 0){
        $dbtable = Projects::with('client:id,fname,lname')->where('is_categorized', 1)->orderBy('updated_at', 'DESC')->get();
      }else{
        $dbtable = Projects::with('client:id,fname,lname')->where('status', $active_status)->where('is_categorized', 1)->orderBy('updated_at', 'DESC')->get();
      }

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){

          $ditems = Invoices::where('projects_id', $data->id)->get();   
          $sum = count($ditems);

          $button = '<div class="hover_buttons"><a href="/projects/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';

          if($data->status == 1){
            if($sum != 0){
              $button .= '<a href="javascript:void(0);" id="add-log-row" data-toggle="tooltip" data-placement="top" data-original-title="Set Status" data-id="'.$data->id.'"  class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-history"></i></a>';
            }

            $button .= '<a href="/projects/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';
          }

          if($sum == 0 && $data->status == 1){
            $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
          }

          return $button;
      })
      ->addColumn('status',  function($data){
        if($data->status){
          $s = $this->status[$data->status];
        }
        return $s;
      })
      ->addColumn('jobs',  function($data){
        $ditems = Invoices::where('projects_id', $data->id)->get();   
        $sum = count($ditems);
        return $sum;
      })
      ->addColumn('url', function($data){
        if(isset($data->url)) {
          $url = $data->url;
          if (strlen($url) >= 50) {
            $n = shortenText($url, 50);
          }
          else {
            $n = $url;
          }

          return '<a href="'.$url.'" target="blank">'.$n.'</a>';
        }else{
          return '';
        }
      })

      ->addColumn('created',  '{{ dateShortOnly($created_at) }}')
      ->addColumn('updated',  '{{ dateTimeFormat($updated_at) }}')
      ->addColumn('checkbox', function($data){
        if($data->status == 1){
          return '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="'. $data->id .'" />';
        }else{
          return '&nbsp;';
        }
      })
        ->rawColumns(['checkbox','action','status','url'])
      ->make(true);
      
    }
        
    return view('projects.index', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status]);;

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
      'status' => 1,
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
    $invoices = Invoices::with('items','client','project')->where('projects_id', $id)->get();
    $sum = count($invoices);
    $updater = User::find($project->updatedby_id);

    if($project->status){
      $s = $this->status[$project->status];
    }


    if(request()->ajax()){

      return datatables()->of($invoices)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/invoices/view/'.$data->id.'" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a></div>';

      $button .= '</div>';

      return $button;
      })
      ->addColumn('total', function($data){
        return '<div class="price">'. priceFormatFancy($data->total) .'</div>';
      })
      ->addColumn('subtotal', function($data){
        return '<div class="price">'. priceFormatFancy($data->subtotal) .'</div>';
      })
      ->addColumn('discount', function($data){
        return '<div class="price">'. ($data->discount + 0) .'%</div>';
      })
      ->addColumn('created', function($data){
          return dateTimeFormatSimple($data->created_at);
      })
      ->addColumn('due_date', function($data){
          if($data->due_date){
            return datetoDpicker($data->due_date);
          }else{
            return '-';
          }
          
      })
      ->addColumn('status', function($data){
        if($data->status){
          $s = $this->status[$data->status];
        }
        return $s;
      })
      ->addColumn('id', function($data){
          return str_pad($data->id, 6, '0', STR_PAD_LEFT);
      })
      ->rawColumns(['total','discount','subtotal','client_name','company_name','action'])
      ->make(true);
      
    }



    return view('projects.view', ['user' => $user, 'project' => $project, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s, 'invoices' => $invoices, 'sum' => $sum ]);
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
        $ditems = Invoices::where('projects_id', $id)->get();   
        $sum = count($ditems);

        if($sum == 0){
          $row = Projects::where('id',$id)->delete();
        }

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
      $req_id = $request->input('id');
      $form = $request->input('formData');

      if(is_array($req_id)){
        $count_updated = 0;

        foreach ($req_id as $row_id) {

            $row = Projects::find($row_id); 
            if($row){
              $row->status = $form['status'];
              $row->updatedby_id = $form['updatedby_id'];
              $row->update();

              $count_updated++;
            }
        }
        return Response::json($count_updated);

      }else{

        $row = Projects::find($req_id); 
        if($row){
          $row->status = $form['status'];
          $row->updatedby_id = $form['updatedby_id'];
          $row->update();

          return Response::json(1);
        }
      }


    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }




  public function invoiceautocomplete(Request $request)
  {
    return Projects::where("client_id","=","{$request->get('c')}")->where("name","LIKE","%{$request->get('q')}%")->where('is_categorized', 1)->where('status', 1)->get();
  }

}
