<?php

namespace App\Http\Controllers;

use App\User;
use App\Machines;
use App\Servcats;
use App\Services;
use App\Servicesrates;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;


class ServicesController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'transactions';
    $this->page_settings['seltab2'] = 'services';
    $this->homeLink = '/services';
  }


  
  public function index()
  {
  
    $user = auth()->user();

    $rateschecker = Services::where('servicesrates_id', 0)->get();

    if(count($rateschecker) > 0){
      Services::where('servicesrates_id', 0)->delete();
    }


    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 2){
        $dbtable = Services::with('current','category')->get();
      }else{
        $dbtable = Services::with('current','category')->where('is_deactivated', $active_status)->get();
      }

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/services/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/services/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

      $sum = 0;

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
      ->addColumn('dprice', function($data){
        $p = number_format(round($data->current->def_price,2), 2);
        return '<div class="price">'.$p.'</div>';
      })
      ->addColumn('uprice', function($data){
        $p = number_format(round($data->current->up_price,2), 2);
        return '<div class="price">'.$p.'</div>';
      })
      ->addColumn('machines', function($data){
        if(count($data->machines) != 0){
          $m = '';
          $x = 0;
          foreach($data->machines as $machine){
            $m .= $machine->name;
            $x++;
            if($x < count($data->machines)){
              $m .= ', ';
            }

          }


          return $m;
        }else{
          return '-';
        }
      })

      ->rawColumns(['checkbox','action','uprice','dprice'])
      ->make(true);
      
    }
        
    return view('services.index', ['user' => $user, 'page_settings'=> $this->page_settings]);
  }


  public function create()
  {
    $user = auth()->user();
    $servcats_id = Servcats::where('is_active', '1')->orderBy('id', 'ASC')->get();

    return view('services.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'servcats_id'=>$servcats_id]);
  }


  public function store(Request $request)
  {


    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'unique:services'],
      'servcats_id' => ['required'],
      'unit' => ['required'],
      'def_price' => ['required'],
      'up_price' => ['required'],
      'machine_id' => ['nullable'],
    ]);


    $query = Services::create([
      'name' => $data['name'],
      'servcats_id' => $data['servcats_id'],
      'unit' => $data['unit'],
      'is_deactivated' => 0,
      'servicesrates_id' => 0,
      'updatedby_id' => $user->id,
    ]);



    if($query){
      $query_prices = Servicesrates::create([
        'services_id' => $query->id,
        'def_price' => $data['def_price'],
        'up_price' => $data['up_price'],
        'updatedby_id' => $user->id,
      ]);
    }

    if($query_prices){
      $query->servicesrates_id = $query_prices->id;
      $query->update();

      $mid_array = array_unique($data['machine_id']);

      if(count($mid_array)>=1){
        foreach ($mid_array as $mid){
          $machine = Machines::find([$mid]); 
          if($machine){
            $query->machines()->attach($machine);
          }
        }
      }

      return notifyRedirect($this->homeLink, 'Added a Service successfully', 'success');
    }

  }

  public function view($id)
  {
    $user = auth()->user();
    $services = Services::with('machines','category','current')->find($id);


    if($services){
      $updater = User::find($services->updatedby_id);

      return view('services.view', ['user' => $user, 'services' => $services, 'page_settings'=> $this->page_settings, 'updater' => $updater]);

    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }

  }


  public function edit($id)
  {
    $user = auth()->user();
    $service = Services::with('machines','current','category')->find($id);
    $servcats_id = Servcats::where('is_active', '1')->orderBy('id', 'ASC')->get();

    if(isset($service)){

      return view('services.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'service' => $service, 'servcats_id' => $servcats_id]);
    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }
  }



  public function update($id)
  {
    $user = auth()->user();
    $service = Services::with('machines','current','category')->find($id);

    $data = request()->validate([
      'name' => ['required'],
      'servcats_id' => ['required'],
      'unit' => ['required'],
      'def_price' => ['required'],
      'up_price' => ['required'],
      'machine_id' => ['nullable'],
    ]);


    if($service->name != $data['name']){
      $name = request()->validate([
        'name' => ['required', 'string', 'unique:services'],
      ]);

      $service->name = $data['name'];
    }


    $service->servcats_id = $data['servcats_id'];
    $service->unit = $data['unit'];
    $service->current->def_price = $data['def_price'];
    $service->current->up_price = $data['up_price'];
    $service->updatedby_id = $user->id;

    $query = $service->update();

    if($data['machine_id']){
      $old_machines = $service->machines->pluck('id')->toArray();
      $sid_array = array_map('intval', array_unique($data['machine_id']));

      $add = array_diff($sid_array,$old_machines);
      $remove = array_diff($old_machines,$sid_array);

      if(count($add)>=1){
        foreach ($add as $sid){
          $machine = Machines::find([$sid]); 
          if($machine){
            $service->machines()->attach($machine);
          }
        }
      }

      if(count($remove)>=1){
        foreach ($remove as $sid){
          $machine = Machines::find([$sid]); 
          if($machine){
            $service->machines()->detach($machine);
          }
        }
      }

    }


    if($query){
      return notifyRedirect($this->homeLink.'/view/'.$id, 'Updated Service '. $service->name .' successfully', 'success');
    }

  }



  public function destroy($id)
  {
    $service = Services::with('machines')->find($id);
    if($service){

      if(request()->ajax()){
        /*
        if(count($service->logs)!=0 ){
          return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
        }*/

        if(count($service->machines)!=0 ){
          $service->machines()->detach();
        }

        $row = Services::where('id',$id)->delete();
        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Service not found', 'danger');
    }
  }





} //end
 