<?php

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Companies;
use App\Regtypes;
use App\Partners;
use App\Sectors;
use App\Projects;
use App\Rules\Url;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

class ClientsController extends Controller
{
  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'customers';
    $this->page_settings['seltab2'] = 'clients';
    $this->homeLink = '/clients';
  }

  public function index()
  {
    $user = auth()->user();

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);




    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 2){
        $clients = DB::table('clients')
              ->leftJoin('companies', 'clients.company_id', '=', 'companies.id')
              ->select(
              'clients.id',
              'clients.fname',
              'clients.lname',
              'clients.email',
              'clients.number',
              'clients.company_id',
              'clients.position',
              'clients.is_deactivated as client_deactivated',
              'companies.name as company_name')
              ->where('clients.id', '!=' , 1)
              ->get();
      }else{
        $clients = DB::table('clients')
              ->leftJoin('companies', 'clients.company_id', '=', 'companies.id')
              ->select(
              'clients.id',
              'clients.fname',
              'clients.lname',
              'clients.email',
              'clients.number',
              'clients.company_id',
              'clients.position',
              'clients.is_deactivated as client_deactivated',
              'companies.name as company_name')
              ->where('clients.is_deactivated', $active_status)
              ->where('clients.id', '!=' , 1)
              ->get();

      }

      return datatables()->of($clients)
        ->addColumn('action', function($data){     

        $button = '<div class="hover_buttons"><a href="/clients/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
        $button .= '<a href="/clients/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

        //now checks only for company and project, soon must include invoices

        $company = Companies::where('client_id', $data->id)->get();        
        $projects = Projects::where('client_id', $data->id)->where('is_categorized', 1)->get();   

        $dcompany = (count($company) != 0 ? 1 : 0);
        $dproject = (count($projects) != 0 ? 1 : 0);
        $sum = $dcompany + $dproject;

        $activate_button = '<a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-success"><i class="fas fa-check"></i></a></div>';

        if($sum == 0){
          if($data->client_deactivated == 1){
            $button .= $activate_button;
          }else{
            $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
          }
        }else{
          if($data->client_deactivated == 0){
            $button .= '<a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-ban"></i></a></div>';
          }else{
            $button .= $activate_button;
          }
        }

      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
        ->rawColumns(['checkbox','action'])

      ->make(true);
      
    }
        


    return view('clients.index', ['user' => $user, 'page_settings'=> $this->page_settings]);

  }


  public function create()
  {
    $user = auth()->user();

    $regtype_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $partner_id = Partners::where('is_active', '1')->where('id', '!=' , 1)->orderBy('id', 'ASC')->get();


    return view('clients.create', ['user' => $user, 'page_settings'=> $this->page_settings,'regtype_id'=>$regtype_id, 'sector_id'=> $sector_id, 'partner_id' => $partner_id]);

  }

  public function store()
  {

    $user = auth()->user();

    $data = request()->validate([
      'fname' => ['required', 'string', 'max:50'],
      'lname' =>['required', 'string', 'max:50'],
      'gender' => ['required'],
      'date_of_birth' => ['nullable'],
      'email' => ['nullable', 'email', 'max:255'],
      'number' => ['nullable', 'max:30', new PhoneNumber],
      'address' => ['nullable'],
      'company_id' => ['nullable'],
      'regtype_id' => ['required'],
      'sector_id' => ['required'],
      'position' => ['nullable', 'string', 'max:100'],
      'url' => ['nullable','string', 'max:255', new Url],
      'skillset' => ['nullable'],
      'hobbies' => ['nullable'],
      'is_freelancer' => ['nullable'],
      'is_food' => ['nullable'],
      'is_pwd' => ['nullable'],
    ]);


    $is_freelancer = (isset($data['is_freelancer']) && $data['is_freelancer'] == 1 ? TRUE : FALSE); 
    $is_food = (isset($data['is_food']) && $data['is_food'] == 1 ? 1 : 0); 
    $is_pwd = (isset($data['is_pwd']) && $data['is_pwd'] == 1 ? 1 : 0); 
    $dob = (isset($data['date_of_birth']) ? dateDatabase($data['date_of_birth']) : $data['date_of_birth']);

    $company_id = ($data['company_id'] == '' ? 1 : $data['company_id']); 


    $query = Clients::create([
      'fname' => $data['fname'],
      'lname' => $data['lname'],
      'gender' => $data['gender'],
      'date_of_birth' => $dob,
      'email' => $data['email'],
      'number' => $data['number'],
      'address' => $data['address'],
      'company_id' => $company_id,
      'regtype_id' => $data['regtype_id'],
      'sector_id' => $data['sector_id'],
      'position' => $data['position'],
      'url' => $data['url'],
      'skillset' => $data['skillset'],
      'hobbies' => $data['hobbies'],
      'is_imported' => 0,
      'is_deactivated' => 0,
      'is_freelancer' => $is_freelancer,
      'is_food' => $is_food,
      'is_pwd' => $is_pwd, 
    
      'updatedby_id' => $user->id,
    ]);


    $company_check = Companies::find($company_id);

    if($company_check->client_id == 1){
      $company_check->client_id = $query->id;
      $company_check->update();
    }

    if($query){
      return notifyRedirect($this->homeLink, 'Added a Client successfully', 'success');
    }

  }



  public function modalStore(Request $request)
  {  
      
      $query = Clients::create([
      'fname' => $request->fname,
      'lname' => $request->lname,
      'email' => $request->email,
      'number' => $request->number,
      'position' => $request->position,
      'sector_id' => $request->sector_id,
      'regtype_id' => $request->regtype_id,
      'company_id' => 1,
      'is_imported' => 0,
      'is_freelancer' => $request->is_freelancer,
      'is_food' => $request->is_food,
      'is_pwd' => $request->is_pwd,
      'is_deactivated' => 0,
      'updatedby_id' => $request->updatedby_id,
      ]);


      return Response::json($query);
  }




  public function view($id)
  {
    $user = auth()->user();

    if($id == 1){
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }

    $client = Clients::with('sector','regtype')->find($id);

    if($client){
      $updater = User::find($client->updatedby_id);

      //now checks only for company and project, soon must include invoices
      $company = Companies::where('client_id', $id)->get();        
      $projects = Projects::where('client_id', $id)->where('is_categorized', 1)->get();   
      
      $dcompany = (count($company) != 0 ? 1 : 0);
      $dproject = (count($projects) != 0 ? 1 : 0);
      $sum = $dcompany + $dproject;


      return view('clients.view', ['user' => $user, 'client' => $client, 'page_settings'=> $this->page_settings, 'updater' => $updater, 'sum' => $sum]);

    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }
  }

  public function edit($id)
  {
    $user = auth()->user();

    if($id == 1){
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }

    $client = Clients::with('company')->find($id);

    if($client){

      $regtype_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();
      $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();

      $partner_id = Partners::where('is_active', '1')->where('id', '!=' , 1)->orderBy('id', 'ASC')->get();



      return view('clients.edit', ['user' => $user, 'page_settings'=> $this->page_settings,'regtype_id'=>$regtype_id, 'sector_id'=> $sector_id, 'client'=> $client, 'partner_id' => $partner_id]);

    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }


  }


  public function update($id)
  {

    $user = auth()->user();
    $client = Clients::find($id);

    $data = request()->validate([
      'fname' => ['required', 'string', 'max:50'],
      'lname' =>['required', 'string', 'max:50'],
      'gender' => ['required'],
      'date_of_birth' => ['nullable'],
      'email' => ['nullable', 'email', 'max:255'],
      'number' => ['nullable', 'max:30', new PhoneNumber],
      'address' => ['nullable'],
      'company_id' => ['nullable'],
      'regtype_id' => ['required'],
      'sector_id' => ['required'],
      'position' => ['nullable', 'string', 'max:100'],
      'url' => ['nullable','string', 'max:255', new Url],
      'skillset' => ['nullable'],
      'hobbies' => ['nullable'],
      'is_freelancer' => ['nullable'],
      'is_food' => ['nullable'],
      'is_pwd' => ['nullable'],
    ]);

    $is_freelancer = (isset($data['is_freelancer']) && $data['is_freelancer'] == 1 ? TRUE : FALSE); 
    $is_food = (isset($data['is_food']) && $data['is_food'] == 1 ? 1 : 0); 
    $is_pwd = (isset($data['is_pwd']) && $data['is_pwd'] == 1 ? 1 : 0); 
    $dob = (isset($data['date_of_birth']) ? dateDatabase($data['date_of_birth']) : $data['date_of_birth']);
    $company_id = ($data['company_id'] == '' ? 1 : $data['company_id']); 
    

    $client->fname = $data['fname'];
    $client->lname = $data['lname'];
    $client->gender = $data['gender'];
    $client->date_of_birth = $dob;
    $client->email = $data['email'];
    $client->number = $data['number'];
    $client->address = $data['address'];
    $client->company_id = $company_id;
    $client->regtype_id = $data['regtype_id'];
    $client->sector_id = $data['sector_id'];
    $client->position = $data['position'];
    $client->url = $data['url'];
    $client->skillset = $data['skillset'];
    $client->hobbies = $data['hobbies'];
    $client->is_freelancer = $is_freelancer;
    $client->is_food = $is_food;
    $client->is_pwd = $is_pwd;  
    $client->updatedby_id = $user->id;

    $query = $client->update();


    $company_check = Companies::find($company_id);

    if($company_check->client_id == 1){
      $company_check->client_id = $client->id;
      $company_check->update();
    }


    if($query){
      return notifyRedirect('/clients/view/'.$client->id, 'Updated client '. $client->fname.' '.$client->lname.' successfully', 'success');
    }

  }

  public function destroy($id)
  {
    if($id == 1){
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }

    $client = Clients::find($id);
    if($client){
      if(request()->ajax()){
        $company = Companies::where('client_id', $client->id)->get();
        if(!$company->isEmpty()){
          return Response::json('deleted_no');
        }else{
          $row = Clients::where('id',$id)->delete();
          return Response::json('deleted_yes');
        }
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }
  }


  public function deactivate($id)
  {
    $client = Clients::find($id);
    if($client){

      if(request()->ajax()){

        $client->is_deactivated = 1;
        $client->update();

        return Response::json('1');
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to deactivate', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }
  }

  public function activate($id)
  {
    $client = Clients::find($id);
    if($client){

      if(request()->ajax()){

        $client->is_deactivated = 0;
        $client->update();

        return Response::json('1');
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to activate', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }
  }

  /*
  public function massrem(Request $request)
  {
    if(request()->ajax()){
      
      $row_id_array = $request->input('id');

        // This is quick delete without dependencies
        // $row = Clients::whereIn('id', $row_id_array);
        // if($row->delete())
        // {
        //   echo 'Data Deleted';
        // }
        

      $count_deleted = 0;

      foreach ($row_id_array as $client_row) {
        $company = Companies::where('client_id', $client_row)->get();
        if($company->isEmpty()){
          $row = Clients::where('id', $client_row)->delete();
          $count_deleted++;
        }
      }

      return Response::json($count_deleted);

    }else{
      return notifyRedirect($this->homeLink, 'Deletion action not permitted', 'danger');
    }
  }
  */

  public function massdeac(Request $request)
  {
    if(request()->ajax()){
      
      $row_id_array = $request->input('id');

      $count = 0;

      foreach ($row_id_array as $client_row) {
        $client = Clients::find($client_row);
        $client->is_deactivated = 1;
        $client->update();
        $count++;
      }

      return Response::json($count);

    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }

  public function massacti(Request $request)
  {
    if(request()->ajax()){
      
      $row_id_array = $request->input('id');

      $count = 0;

      foreach ($row_id_array as $client_row) {
        $client = Clients::find($client_row);
        $client->is_deactivated = 0;
        $client->update();
        $count++;
      }

      return Response::json($count);

    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }


  public function dblist()
  {
    /*
    $clients = DB::table('clients')->select('*');
    return datatables()->of($clients)
        ->make(true);
    */

    /*
    $clients = DB::table('clients')
              ->leftJoin('companies', 'clients.company_id', '=', 'companies.id')
              ->select(
              'clients.id',
              'clients.fname',
              'clients.lname',
              'clients.email',
              'clients.number',
              'clients.company_id',
              'clients.position',
              'companies.name as company_name')
              ->get();
    */

        $clients = DB::table('clients')
              ->leftJoin('companies', 'clients.company_id', '=', 'companies.id')
              ->select(
              'clients.id',
              'clients.fname',
              'clients.lname',
              'clients.email',
              'clients.number',
              'clients.company_id',
              'clients.position',
              'clients.is_deactivated as client_deactivated',
              'companies.name as company_name')
              ->where('clients.id', '!=' , 1)
              ->get();

    return datatables()->of($clients)
        ->make(true);
  }

  public function autocomplete(Request $request)
  {
      /*
      $data = Companies::select("name")
              ->where("name","LIKE","%{$request->input('query')}%")
              ->get();
      */

      return Clients::where("lname","LIKE","%{$request->get('q')}%")->where('is_deactivated', 0)->get();
      
      //return response()->json($data);
  }




}
