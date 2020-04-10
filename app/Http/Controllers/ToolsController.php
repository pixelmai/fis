<?php

namespace App\Http\Controllers;
use App\Logs;
use App\User;
use App\Suppliers;
use App\Tools;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;


class ToolsController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'equipment';
    $this->page_settings['seltab2'] = 'tools';
    $this->homeLink = '/tools';

    $this->status = array( 
      '1' => 'Available', 
      '2' => 'Damaged',
      '3' => 'Borrowed'
    );
  }


  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 2){
        $dbtable = Tools::with('logs')->get();
      }else{
        $dbtable = Tools::with('logs')->where('is_deactivated', $active_status)->get();
      }


      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/tools/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="javascript:void(0);" id="add-log-row" data-toggle="tooltip" data-placement="top" data-original-title="Add Log" data-id="'.$data->id.'"  class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-history"></i></a>';
      $button .= '<a href="/tools/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

      if(count($data->logs) == 0){
        $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
      }else{
        if($data->is_deactivated == 0){
          $button .= '<a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-ban"></i></a></div>';
        }else{
          $button .= '<a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-success"><i class="fas fa-check"></i></a></div>';
        }
      }
      return $button;

      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
      ->addColumn('number', function($data){
        if($data->suppliers){
          $num = count($data->suppliers);
        }else{
          $num = 0;
        }
        return $num;
      })
      ->addColumn('status', function($data){
        if($data->status){
          $s = $this->status[$data->status];
        }
        return $s;
      })
      ->addColumn('updated', function($data){
        return $data->updated_at;
      })

      ->rawColumns(['checkbox','action'])
      ->make(true);
    }
        
    return view('tools.index', ['user' => $user, 'page_settings'=> $this->page_settings,  'status' => $this->status]);


  }

  public function create()
  {
    $user = auth()->user();

    return view('tools.create', ['user' => $user, 'page_settings'=> $this->page_settings]);
  }

  public function store(Request $request)
  {

    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'model' => ['nullable'],
      'brand' => ['nullable'],
      'notes' => ['nullable'],
      'supplier_id' => ['nullable'],
    ]);

    $sid_array = array_unique($data['supplier_id']);
    

    $query = Tools::create([
      'name' => $data['name'],
      'status' => 1,
      'model' => $data['model'],
      'brand' => $data['brand'],
      'notes' => $data['notes'],
      'is_deactivated' => 0,
      'updatedby_id' => $user->id,
    ]);

    if(count($sid_array)>=1){
      foreach ($sid_array as $sid){
        $supplier = Suppliers::find([$sid]); 
        if($supplier){
          $query->suppliers()->attach($supplier);
        }
      }
    }


    if($query){
      return notifyRedirect($this->homeLink, 'Added a Tool successfully', 'success');
    }

  }

  public function view($id)
  {
    $user = auth()->user();
    $tool = Tools::with('logs')->find($id);
    $logs = Logs::where('tool_id', $id)->orderBy('updated_at', 'DESC')->get();



    if($tool){
      $updater = User::find($tool->updatedby_id);
      if($tool->status){
        $s = $this->status[$tool->status];
      }

      return view('tools.view', ['user' => $user, 'tools' => $tool, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s, 'status'=> $this->status, 'logs' => $logs]);

    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }

  }


  public function edit($id)
  {
    $user = auth()->user();
    $tool = Tools::with('suppliers')->find($id);

    if(isset($tool)){

      return view('tools.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'tool' => $tool]);
    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }
    
  }


  public function update($id)
  {
    $user = auth()->user();
    $tool = Tools::find($id);

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'model' => ['nullable'],
      'brand' => ['nullable'],
      'notes' => ['nullable'],
      'supplier_id' => ['nullable'],
    ]);

    $tool->name = $data['name'];
    $tool->model = $data['model'];
    $tool->brand = $data['brand'];
    $tool->notes = $data['notes'];
    $tool->updatedby_id = $user->id;

    $query = $tool->update();

    if($data['supplier_id']){
      $old_suppliers = $tool->suppliers->pluck('id')->toArray();
      $sid_array = array_map('intval', array_unique($data['supplier_id']));

      $add = array_diff($sid_array,$old_suppliers);
      $remove = array_diff($old_suppliers,$sid_array);

      if(count($add)>=1){
        foreach ($add as $sid){
          $supplier = Suppliers::find([$sid]); 
          if($supplier){
            $tool->suppliers()->attach($supplier);
          }
        }
      }

      if(count($remove)>=1){
        foreach ($remove as $sid){
          $supplier = Suppliers::find([$sid]); 
          if($supplier){
            $tool->suppliers()->detach($supplier);
          }
        }
      }


    }


    if($query){
      return notifyRedirect($this->homeLink.'/view/'.$id, 'Updated Tool '. $tool->name .' successfully', 'success');
    }

  }

  public function destroy($id)
  {
    $tool = Tools::with('suppliers')->find($id);
    if($tool){

      if(request()->ajax()){
        if(count($tool->logs)!=0 ){
          return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
        }

        if(count($tool->suppliers)!=0 ){
          $tool->suppliers()->detach();
        }

        $row = Tools::where('id',$id)->delete();
        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }
  }

  public function deactivate($id)
  {
    $tool = Tools::find($id);
    if($tool){

      if(request()->ajax()){

        $tool->is_deactivated = 1;
        $tool->update();

        return Response::json('1');
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to deactivate', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }
  }

  public function activate($id)
  {
    $tool = Tools::find($id);
    if($tool){

      if(request()->ajax()){

        $tool->is_deactivated = 0;
        $tool->update();

        return Response::json('1');
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to activate', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
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

            $row = Tools::find($row_id); 
            if($row){
              $row->status = $form['status'];
              $row->updatedby_id = $form['updatedby_id'];
              $row->update();


              $query = Logs::create([
                'tool_id' => $row_id,
                'status' => $form['status'],
                'notes' => $form['notes'],
                'updatedby_id' => $form['updatedby_id']
              ]);

              $count_updated++;
            }
        }
        return Response::json($count_updated);
      }else{

        $row = Tools::find($req_id); 
        if($row){
          $row->status = $form['status'];
          $row->updatedby_id = $form['updatedby_id'];
          $row->update();

          $query = Logs::create([
            'tool_id' => $req_id,
            'status' => $form['status'],
            'notes' => $form['notes'],
            'updatedby_id' => $form['updatedby_id']
          ]);

          return Response::json(1);
        }
      }


    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }


  public function statusedit(Request $request)
  {
    if(request()->ajax()){
      $tool_id = $request->input('id');
      $log_id = $request->input('logid');
      $form = $request->input('formData');

      $row = Tools::find($tool_id); 
      if($row){
        $row->status = $form['status'];
        $row->updatedby_id = $form['updatedby_id'];
        $row->update();

        $log = Logs::find($log_id); 

        if($log){

          $log->status = $form['status'];
          $log->notes = $form['notes'];
          $log->updatedby_id = $form['updatedby_id'];

          $log->update();

          return Response::json(1);

        }

        
      }
      


    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }



}
