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

      //$dbtable = Suppliers::where('is_deactivated', 0)->orderBy('updated_at', 'DESC')->select();
      $dbtable = Tools::orderBy('is_deactivated', 'ASC')->orderBy('updated_at', 'DESC')->get();

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/tools/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/tools/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';
      $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
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
      ->rawColumns(['checkbox','action'])
      ->make(true);
    }
        
    return view('tools.index', ['user' => $user, 'page_settings'=> $this->page_settings]);


  }

  public function create()
  {
    $user = auth()->user();

    return view('tools.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status]);
  }

  public function store(Request $request)
  {
    /* SIMPLE ADD 
      $user = auth()->user();
      $tool = new Tools;
      $tool->name = 'God of War';
      $tool->updatedby_id = $user->id;
      $tool->save();
      $supplier = Suppliers::find([2, 3]); //suppliers 2 and 3
      $tool->suppliers()->attach($supplier);
      return 'Success';
    */

    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'status' => ['required'],
      'model' => ['nullable'],
      'brand' => ['nullable'],
      'notes' => ['nullable'],
      'supplier_id' => ['nullable'],
    ]);

    $sid_array = array_unique($data['supplier_id']);
    

    $query = Tools::create([
      'name' => $data['name'],
      'status' => $data['status'],
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


    if($tool){
      $updater = User::find($tool->updatedby_id);
      if($tool->status){
        $s = $this->status[$tool->status];
      }

      return view('tools.view', ['user' => $user, 'tools' => $tool, 'page_settings'=> $this->page_settings, 'updater' => $updater, 'status'=> $s, 'status_list'=> $this->status]);

    }else{
      return notifyRedirect($this->homeLink, 'Tool not found', 'danger');
    }

  }


  public function edit($id)
  {
    $user = auth()->user();
    $tool = Tools::with('suppliers')->find($id);

    if(isset($tool)){

      return view('tools.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'tool' => $tool, 'status' => $this->status]);
    }else{
      return notifyRedirect($this->homeLink, 'Company not found', 'danger');
    }
    
  }


  public function update($id)
  {

    $user = auth()->user();
    $tool = Tools::find($id);

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'status' => ['required'],
      'model' => ['nullable'],
      'brand' => ['nullable'],
      'notes' => ['nullable'],
      'supplier_id' => ['nullable'],
    ]);

    $tool->name = $data['name'];
    $tool->status = $data['status'];
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
}
