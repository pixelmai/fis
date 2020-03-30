<?php

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Companies;
use App\Regtypes;
use App\Partners;
use App\Sectors;
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


  public function create()
  {
    $user = auth()->user();
    $partner_id = Partners::where('is_active', '1')->where('id', '!=' , 1)->orderBy('id', 'ASC')->get();
    $regtype_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();


    return view('companies.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'regtype_id'=>$regtype_id, 'sector_id'=> $sector_id, 
      'partner_id' => $partner_id]);


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
      'client_id' => 0,
      'partner_id' => $partner_id,
      'is_imported' => 0,
      'is_partner' => $is_partner,
      'updatedby_id' => $request->updatedby_id,
      ]);


      return Response::json($query);
  }

  public function show(Companies $companies)
  {
    
  }

  public function edit(Companies $companies)
  {
    
  }


  public function update(Request $request, Companies $companies)
  {
    //
  }


  public function destroy($id)
  {
    $company = Companies::find($id);
    if($company){

      //if(request()->ajax()){
      
        $company_count = Companies::where('client_id', $company->client_id)->get();
        $client = Clients::find($company->client_id);

        if((count($company_count)) == 1 && ($client->company_id == $company->id)){
          $client->company_id = 1;
          $client->update();
        }elseif (count($company_count) >= 2){
          foreach ($company_count as $company_row) {
            if($company_row->id != $id){
              $client->company_id = $company_row->id;
              $client->update();
            }
          }
        }

        $row = Companies::where('id',$id)->delete();
        return Response::json($row);

      /*
      }else{
        return notifyRedirect('/clients', 'Unauthorized to delete', 'danger');
      } */
    }else{
      return notifyRedirect('/clients', 'Client not found', 'danger');
    }

  }


  public function massrem(Request $request)
  {
    if(request()->ajax()){
      
      $row_id_array = $request->input('id');

      $count_deleted = 0;

      foreach ($row_id_array as $company_row) {
        $company = Companies::find($company_row);
        $company_count = Companies::where('client_id', $company->client_id)->get();
        $client = Clients::find($company->client_id);


        if((count($company_count)) == 1 && ($client->company_id == $company_row)){
          $client->company_id = 1;
          $client->update();
        }elseif (count($company_count) >= 2){
          foreach ($company_count as $compcheck) {
            if($compcheck->id != $company_row){
              $client->company_id = $compcheck->id;
              $client->update();
            }
          }
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

      return Clients::where("lname","LIKE","%{$request->get('q')}%")->get();


      //return response()->json($data);
  }



}
