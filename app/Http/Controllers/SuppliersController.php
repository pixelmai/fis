<?php

namespace App\Http\Controllers;

use App\User;
use App\Suppliers;
use App\Rules\Url;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

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
    $this->page_title = 'Suppliers';

  }    

  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 2){
        $dbtable = Suppliers::orderBy('is_deactivated', 'ASC')->orderBy('updated_at', 'DESC')->get();
      }else{
        $dbtable = Suppliers::orderBy('is_deactivated', 'ASC')->where('is_deactivated', $active_status)->orderBy('updated_at', 'DESC')->get();
      }

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/suppliers/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/suppliers/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';


      $dtools = (count($data->tools->pluck('id')->toArray()) != 0 ? 1 : 0);
      $dmachines = (count($data->machines->pluck('id')->toArray()) != 0 ? 1 : 0);

      $sum = $dtools + $dmachines;

      $activate_button = '<a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-success"><i class="fas fa-check"></i></a></div>';


      if($sum == 0){
        if($data->is_deactivated == 1){
            $button .= $activate_button;
        }else{
            $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
        }
      }else{
        if($data->is_deactivated == 0){
          $button .= '<a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-ban"></i></a></div>';
        }else{
          $button .= $activate_button;
        }      
      }


      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
        ->addColumn('url', function($data){
          if($data->url){
            if(strlen($data->url)>30){
              $link = '<a href="'.$data->url.'">Click here</a>';
            }else{
              $link = '<a href="'.$data->url.'">'.$data->url.'</a>';
            }
          }else{
            $link = '';
          }
        return $link;
      })
      ->rawColumns(['checkbox','action','url'])
      ->make(true);
      
    }
        
    return view('suppliers.index', ['user' => $user, 'page_settings'=> $this->page_settings, 'page_title'=> $this->page_title]);



  }


  public function create()
  {
    $user = auth()->user();
    return view('suppliers.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'page_title'=> $this->page_title]);

  }


  public function store(Request $request)
  {


    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255', 'unique:suppliers'],
      'contact_person' => ['string'],
      'email' => ['nullable', 'email', 'max:255'],
      'number' => ['nullable', 'max:30', new PhoneNumber],
      'url' => ['nullable', 'string', 'max:255', new Url],
      'address' => ['nullable'],
      'specialty' => ['nullable'],
      'supplies' => ['nullable'],
    ]);


    $query = Suppliers::create([
      'name' => $data['name'],
      'contact_person' => $data['contact_person'],
      'email' => $data['email'],
      'number' => $data['number'],
      'address' => $data['address'],
      'url' => $data['url'],
      'specialty' => $data['specialty'],
      'supplies' => $data['supplies'],
      'is_deactivated' => 0,
      'updatedby_id' => $user->id,
    ]);

    if($query){
      return notifyRedirect($this->homeLink, 'Added a Supplier successfully', 'success');
    }


  }


  public function view($id)
  {
    $user = auth()->user();
    $supplier = Suppliers::find($id);
    $supplies = '';

    if($supplier){
      $updater = User::find($supplier->updatedby_id);
      
      if(!empty($supplier->supplies)){
        $supplies = array_map('trim', explode(';', $supplier->supplies));
      }


      $dtools = (count($supplier->tools->pluck('id')->toArray()) != 0 ? 1 : 0);
      $dmachines = (count($supplier->machines->pluck('id')->toArray()) != 0 ? 1 : 0);

      $sum = $dtools + $dmachines;


      return view('suppliers.view', ['user' => $user, 'supplier' => $supplier, 'page_settings'=> $this->page_settings, 'updater' => $updater, 'supplies' => $supplies, 'sum' => $sum, 'page_title'=> $this->page_title]);

    }else{
      return notifyRedirect($this->homeLink, 'Supplier not found', 'danger');
    }
  }

  public function edit($id)
  {
    $user = auth()->user();
    $supplier = Suppliers::find($id);

    if(isset($supplier)){
      return view('suppliers.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'supplier' => $supplier, 'page_title'=> $this->page_title]);

    }else{
      return notifyRedirect($this->homeLink, 'Supplier not found', 'danger');
    }


  }


  public function update($id)
  {

    $user = auth()->user();
    $supplier = Suppliers::find($id);

    $data = request()->validate([
      'name' => ['string'],
      'contact_person' => ['string'],
      'email' => ['nullable', 'email', 'max:255'],
      'number' => ['nullable', 'max:30', new PhoneNumber],
      'url' => ['nullable', 'string', 'max:255', new Url],
      'address' => ['nullable'],
      'specialty' => ['nullable'],
      'supplies' => ['nullable'],
    ]);


    if($supplier->name != $data['name']){
      request()->validate([
        'name' => ['required', 'string', 'max:255', 'unique:suppliers'],
      ]);

      $supplier->name = $data['name'];
    }
    $supplier->contact_person = $data['contact_person'];
    $supplier->email = $data['email'];
    $supplier->url = $data['url'];
    $supplier->number = $data['number'];
    $supplier->address = $data['address'];
    $supplier->specialty = $data['specialty'];
    $supplier->supplies = $data['supplies'];
    $supplier->updatedby_id = $user->id;

    $query = $supplier->update();

    if($query){
      return notifyRedirect($this->homeLink.'/view/'.$id, 'Updated supplier '. $supplier->name .' successfully', 'success');
    }

  }


  public function destroy($id)
  {
    $supplier = Suppliers::find($id);
    if($supplier){
      if(request()->ajax()){
        $row = Suppliers::where('id',$id)->delete();
        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Supplier not found', 'danger');
    }
  }

  public function autocomplete(Request $request)
  {
    return Suppliers::where("name","LIKE","%{$request->get('q')}%")->where('is_deactivated', 0)->get();
  }



  public function deactivate($id)
  {
    $supplier = Suppliers::find($id);
    if($supplier){

      if(request()->ajax()){

        $supplier->is_deactivated = 1;
        $supplier->update();

        return Response::json('1');
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to deactivate', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Supplier not found', 'danger');
    }
  }

  public function activate($id)
  {
    $supplier = Suppliers::find($id);
    if($supplier){

      if(request()->ajax()){

        $supplier->is_deactivated = 0;
        $supplier->update();

        return Response::json('1');
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to activate', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Supplier not found', 'danger');
    }
  }


  public function massdeac(Request $request)
  {
    if(request()->ajax()){
      
      $row_id_array = $request->input('id');

      $count = 0;

      foreach ($row_id_array as $supplier_row) {
        $supplier = Suppliers::find($supplier_row);
        $supplier->is_deactivated = 1;
        $supplier->update();
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

      foreach ($row_id_array as $supplier_row) {
        $supplier = Suppliers::find($supplier_row);
        $supplier->is_deactivated = 0;
        $supplier->update();
        $count++;
      }


      return Response::json($count);

    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }




}
