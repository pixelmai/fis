<?php

// TODO: Must implement Disable/Delete swaps when invoices are ready

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Companies;
use App\Regtypes;
use App\Partners;
use App\Sectors;
use App\Rules\Url;
use App\Rules\PhoneNumber;
use Illuminate\Support\Str;
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

    $client_checker = Companies::where('client_id', 1)->get();

    if(count($client_checker) > 0){
      Companies::where('client_id', 1)->delete();
    }

    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);

      if($active_status == 2){
        $dbtable = Companies::with('partner:id,name', 'contactperson:id,fname,lname')->where('id', '!=' , 1)->select();
      }else{
        $dbtable = Companies::with('partner:id,name', 'contactperson:id,fname,lname')->where('is_deactivated', $active_status)->where('id', '!=' , 1)->select();
      }

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


  public function create()
  {
    $user = auth()->user();
    $partner_id = Partners::where('is_active', '1')->where('id', '!=' , 1)->orderBy('id', 'ASC')->get();
    $regtype_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $token = Str::random(60);

    return view('companies.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'regtype_id'=>$regtype_id, 'sector_id'=> $sector_id, 
      'partner_id' => $partner_id, 'dtoken' => $token ]);


  }

  public function store(Request $request)
  {

    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255', 'unique:companies'],
      'email' => ['nullable', 'email', 'max:255'],
      'number' => ['nullable', 'max:30', new PhoneNumber],
      'url' => ['nullable', 'string', 'max:255', new Url],
      'address' => ['nullable'],
      'description' => ['nullable'],
      'client_id' => ['required'],
      'is_partner' => ['nullable'],
      'partner_id' => ['required'],
    ]);


    if(isset($data['is_partner']) && $data['is_partner'] == 1){
      $is_partner = TRUE;
      $partner_id = $data['partner_id'];
    }else{
      $is_partner = FALSE;
      $partner_id = 1;
    }

    $query = Companies::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'number' => $data['number'],
      'address' => $data['address'],
      'client_id' => $data['client_id'],
      'partner_id' => $partner_id,
      'url' => $data['url'],
      'description' => $data['description'],
      'is_imported' => 0,
      'is_partner' => $is_partner, 
      'updatedby_id' => $user->id,
    ]);

    $client_check = Clients::find($data['client_id']);

    if(!isset($client_check)){
      return notifyRedirect($this->homeLink, 'Client non-existent', 'danger');
    }

    if($client_check->company_id == 1){
      $client_check->company_id = $query->id;
      $client_check->update();
    }

    if($query){
      return notifyRedirect($this->homeLink, 'Added a Company successfully', 'success');
    }
  }

  public function modalStore(Request $request)
  {  
  
      if($request->is_partner == 1){
        $is_partner = TRUE;
        $partner_id = $request->partner_id;
      }else{
        $is_partner = FALSE;
        $partner_id = 1;
      }

      $data = request()->validate([
        'name' => ['required', 'string', 'max:255', 'unique:companies'],
      ]);


      $query = Companies::create([
      'name' => $request->name,
      'email' => $request->email,
      'number' => $request->number,
      'address' => $request->address,
      'description' => $request->description,
      'url' => $request->url,
      'client_id' => 1,
      'partner_id' => $partner_id,
      'is_imported' => 0,
      'is_partner' => $is_partner,
      'updatedby_id' => $request->updatedby_id,
      ]);


      return Response::json($query);
  }

  public function view($id)
  {
    $user = auth()->user();

    if($id == 1){
      return notifyRedirect($this->homeLink, 'Company not found', 'danger');
    }

    $company = Companies::with('contactperson','partner','clients')->find($id);
    $employees = Clients::where('company_id',$id)->get();
    $emp_list = array();
    $found = FALSE;

    foreach ($employees as $employee) {
      $emp = array( 
        "id" => $employee->id, 
        "fname" => $employee->fname, 
        "lname" => $employee->lname, 
      );

      if($company->contactperson->id == $employee->id){
        $found = TRUE;
      }

      array_push($emp_list, $emp);
    }


    if($found == FALSE){
      $emp = array( 
        "id" => $company->contactperson->id, 
        "fname" => $company->contactperson->fname, 
        "lname" => $company->contactperson->lname, 
      );

      array_push($emp_list, $emp);
    }



    if($company){
      $updater = User::find($company->updatedby_id);
      return view('companies.view', ['user' => $user, 'company' => $company, 'page_settings'=> $this->page_settings, 'updater' => $updater, 'employees'=> $emp_list]);

    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }
  }


  public function edit($id)
  {
    $user = auth()->user();

    if($id == 1){
      return notifyRedirect($this->homeLink, 'Company not found', 'danger');
    }

    $company = Companies::with('contactperson')->find($id);

    if($company){
      $partner_id = Partners::where('is_active', '1')->where('id', '!=' , 1)->orderBy('id', 'ASC')->get();
      $regtype_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();

      $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();

      $token = Str::random(60);

      return view('companies.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'regtype_id'=>$regtype_id, 'sector_id'=> $sector_id, 
        'partner_id' => $partner_id, 'company' => $company, 'dtoken' => $token ]);
    }else{
      return notifyRedirect($this->homeLink, 'Company not found', 'danger');
    }



  }


  public function update($id)
  {
    $user = auth()->user();
    $company = Companies::find($id);

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['nullable', 'email', 'max:255'],
      'number' => ['nullable', 'max:30', new PhoneNumber],
      'url' => ['nullable', 'string', 'max:255', new Url],
      'address' => ['nullable'],
      'description' => ['nullable'],
      'client_id' => ['required'],
      'is_partner' => ['nullable'],
      'partner_id' => ['required'],
    ]);

    if(isset($data['is_partner']) && $data['is_partner'] == 1){
      $is_partner = TRUE;
      $partner_id = $data['partner_id'];
    }else{
      $is_partner = FALSE;
      $partner_id = 1;
    }

    if($company->name != $data['name']){
      $name = request()->validate([
        'name' => ['required', 'string', 'max:255', 'unique:companies']
      ]);

      $company->name = $data['name'];
    }

    
    $company->email = $data['email'];
    $company->number = $data['number'];
    $company->address = $data['address'];
    $company->client_id = $data['client_id'];
    $company->partner_id = $partner_id;
    $company->url = $data['url'];
    $company->description = $data['description'];
    $company->is_partner = $is_partner; 
    $company->updatedby_id = $user->id;


    $query = $company->update();

    $client_check = Clients::find($data['client_id']);

    if(!isset($client_check)){
      return notifyRedirect($this->homeLink, 'Client non-existent', 'danger');
    }
    
    if($client_check->company_id == 1){
      $client_check->company_id = $id;
      $client_check->update();
    }


    if($query){
      return notifyRedirect('/companies/view/'.$id, 'Updated company '. $company->name .' successfully', 'success');
    }



  }


  public function destroy($id)
  {
    if($id == 1){
      return notifyRedirect($this->homeLink, 'Company not found', 'danger');
    }

    $company = Companies::find($id);
    if($company){

      if(request()->ajax()){
        $total_clients = Clients::where('company_id', $id)->get(); 

        if (count($total_clients) > 1){
          foreach ($total_clients as $client_row) {
            $client = Clients::find($client_row->id);
            $client_comp = Companies::where('client_id', $client->id)->get();
            $this->deleteClientUpdater($client, $client_comp, $id);
          }
        }else{
          $client = Clients::find($company->client_id);
          $client_comp = Companies::where('client_id', $client->id)->get();
          $this->deleteClientUpdater($client, $client_comp, $id);
        }


        $row = Companies::where('id',$id)->delete();
        return Response::json($row);

      
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      } 
    }else{
      return notifyRedirect($this->homeLink, 'Client not found', 'danger');
    }

  }


  public function massrem(Request $request)
  {

    if(request()->ajax()){
      
      $row_id_array = $request->input('id');

      $count_deleted = 0;

      foreach ($row_id_array as $company_row) {
        $company = Companies::find($company_row);
        $total_clients = Clients::where('company_id', $company_row)->get(); 

        if (count($total_clients) > 1){
          foreach ($total_clients as $client_row) {
            $client = Clients::find($client_row->id);
            $client_comp = Companies::where('client_id', $client->id)->get();
            $this->deleteClientUpdater($client, $client_comp, $company_row);
          }
        }else{
          $client = Clients::find($company->client_id);
          $client_comp = Companies::where('client_id', $client->id)->get();
          $this->deleteClientUpdater($client, $client_comp, $company_row);
        }

  
        $row = Companies::where('id',$company_row)->delete();
        $count_deleted++;
      }

      return Response::json($count_deleted);

    }else{
      return notifyRedirect($this->homeLink, 'Deletion action not permitted', 'danger');
    }
  }




  public function dblist()
  {

    $clients = Companies::with('partner:id,name', 'contactperson:id,fname,lname')->where('id', '!=' , 1)->get();

      $db= datatables()->of($clients)->make(true);
      print "<pre>";
      print_r($db);
      print "</pre>";
  }


  public function autocomplete(Request $request)
  {

      /*
      $data = Companies::select("name")
              ->where("name","LIKE","%{$request->input('query')}%")
              ->get();
      */

      return Companies::where("name","LIKE","%{$request->get('q')}%")->where('is_deactivated', 0)->get();

      //return response()->json($data);

      
  }


  public function invoiceautocomplete(Request $request)
  {

    // FIXED:
    // There's a bug wherein things are being showed automatically irregardless of string

    $id = $request->get('c');
    $q = $request->get('q');

    //return Companies::where("client_id","=","{$request->get('c')}")->where("name","LIKE","%{$request->get('q')}%")->where('is_deactivated', 0)->get();


    $from_companies = Companies::select('id','name')->where("client_id","=", $id)->where('is_deactivated', 0)->where("name","LIKE","%{$request->get('q')}%")->get();

    $client = Clients::select('company_id')->with('company')->find($id); //just 1

    $comp_list = array();
    $found = FALSE;


    if($client){
      $checker = stripos($client->company->name, $q);
      if(is_numeric($checker) == TRUE ){

        $com = array( 
          "id" => $client->company->id, 
          "name" => $client->company->name, 
        );

        $found = TRUE;
        array_push($comp_list, $com);
      }
      
    }

    if(count($from_companies) != 0 && $found  == FALSE){
      foreach ($from_companies as $company) {
        $com = array( 
          "id" => $company->id, 
          "name" => $company->name, 
        );

        if($client->company->id == $company->id){
          $found = TRUE;
        }

        array_push($comp_list, $com);
        
      }
    }

    return $comp_list;


  }


  function deleteClientUpdater($client, $comp, $id)
  {
    if((count($comp)) == 1 && ($client->company_id == $id)){
      $client->company_id = 1;
      $client->update();
    }elseif (count($comp) >= 2){
      if($client->company_id == $id){
        foreach ($comp as $compcheck) {
          if($compcheck->id != $id){
            $client->company_id = $compcheck->id;
            $client->update();
          }
        }
      }
    }else{
      $client->company_id = 1;
      $client->update();
    }
  }

}
