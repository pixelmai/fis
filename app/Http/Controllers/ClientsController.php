<?php

namespace App\Http\Controllers;

use App\User;
use App\Clients;
use App\Regtypes;
use App\Sectors;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Yajra\Datatables\Datatables;

class ClientsController extends Controller
{
  private $page_settings;
  private $unauth;

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

    if(request()->ajax()){

      $clients = DB::table('clients')->select('id','fname','lname','email','number','company_id','position');
      return datatables()->of($clients)
        ->addColumn('action', function($data){
      $button = '<a href="/clients/view/'.$data->id.'" data-toggle="tooltip" data-placement="left" data-original-title="View" class="edit btn btn-outline-secondary btn-sm">
        <i class="fas fa-eye"></i>
      </a>';
      $button .= '<a href="" data-toggle="tooltip" data-placement="left" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post">
        <i class="fas fa-edit"></i>
      </a>';
      $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="left" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a>';
      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
        ->rawColumns(['checkbox','action'])

      ->make(true);
      
    }
        

    return view('clients.index', ['user' => $user, 'page_settings'=> $this->page_settings]);

    //return view('clients.index', ['user' => $user, 'clients' => $clients, 'page_settings'=> $this->page_settings]);

  }


  public function create()
  {
    $user = auth()->user();

    $regtype_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();

    return view('clients.create', ['user' => $user, 'page_settings'=> $this->page_settings,'regtype_id'=>$regtype_id, 'sector_id'=> $sector_id]);

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
      'url' => ['nullable','string', 'max:255'],
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


    $query = Clients::create([
      'fname' => $data['fname'],
      'lname' => $data['lname'],
      'gender' => $data['gender'],
      'date_of_birth' => $dob,
      'email' => $data['email'],
      'number' => $data['number'],
      'address' => $data['address'],
      'company_id' => $data['company_id'],
      'regtype_id' => $data['regtype_id'],
      'sector_id' => $data['sector_id'],
      'position' => $data['position'],
      'url' => $data['url'],
      'skillset' => $data['skillset'],
      'hobbies' => $data['hobbies'],
      'is_imported' => 0,
    
      'is_freelancer' => $is_freelancer,
      'is_food' => $is_food,
      'is_pwd' => $is_pwd, 
    
      'updatedby_id' => $user->id,
    ]);


    if($query){
      return notifyRedirect($this->homeLink, 'Added a Client successfully', 'success');
    }

  }

  public function view($id)
  {
    $user = auth()->user();
    $client = Clients::with('sector','regtype')->find($id);


    return view('clients.view', ['user' => $user, 'client' => $client, 'page_settings'=> $this->page_settings]);


  }

  public function edit($id)
  {
    dd('bunay');
  }


  public function update(Request $request, Clients $clients)
  {
  //
  }

  public function destroy($id)
  {
    if(request()->ajax()){
      $row = Clients::where('id',$id)->delete();
      return Response::json($row);
    }else{
      $row = Clients::where('id',$id)->delete();
      return notifyRedirect($this->homeLink, 'Successfully deleted client.' , 'warning');
    }
  }

  public function massrem(Request $request)
  {
    if(request()->ajax()){
      $row_id_array = $request->input('id');
      $row = Clients::whereIn('id', $row_id_array);
      if($row->delete())
      {
          echo 'Data Deleted';
      }
    }else{
      return notifyRedirect($this->homeLink, 'Deletion action not permitted', 'danger');
    }
  }
}
