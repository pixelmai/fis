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

    //$clients = Clients::orderBy('fname', 'ASC')->orderBy('lname', 'ASC')->paginate(10);

    return view('clients.index', ['user' => $user, 'page_settings'=> $this->page_settings]);

    //return view('clients.index', ['user' => $user, 'clients' => $clients, 'page_settings'=> $this->page_settings]);

  }


  public function create()
  {
    $user = auth()->user();

    $registration_id = Regtypes::where('is_active', '1')->orderBy('id', 'ASC')->get();

    $sector_id = Sectors::where('is_active', '1')->orderBy('id', 'ASC')->get();

    return view('clients.create', ['user' => $user, 'page_settings'=> $this->page_settings,'registration_id'=>$registration_id, 'sector_id'=> $sector_id]);

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
      'registration_id' => ['required'],
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
      'registration_id' => $data['registration_id'],
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

  public function show(Clients $clients)
  {
    //
  }

  public function edit(Clients $clients)
  {
    //
  }


  public function update(Request $request, Clients $clients)
  {
    //
  }

  public function destroy(Clients $clients)
  {
    //
  }

  public function clientsList()
  {
      $clients = DB::table('clients')->select('fname','lname','email','number','company_id','position');
      return datatables()->of($clients)
          ->make(true);
  }

}
