<?php

namespace App\Http\Controllers;
use App\Logs;
use App\User;
use App\Machines;
use App\Suppliers;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;


class MachinesController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'equipment';
    $this->page_settings['seltab2'] = 'machines';
    $this->homeLink = '/machines';

    $this->status = array( 
      '1' => 'Available', 
      '2' => 'Damaged',
      '3' => 'Under Maintenance'
    );
  }


  public function index()
  {
    $user = auth()->user();

    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 2){
        $dbtable = Machines::with('logs')->get();
      }else{
        $dbtable = Machines::with('logs')->where('is_deactivated', $active_status)->get();
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
        
    return view('machines.index', ['user' => $user, 'page_settings'=> $this->page_settings,  'status' => $this->status]);
  }


  public function create()
  {
    $user = auth()->user();

    return view('machines.create', ['user' => $user, 'page_settings'=> $this->page_settings]);
  }


  public function store(Request $request)
  {

    $user = auth()->user();

    $data = request()->validate([
      'name' => ['required', 'string', 'max:255'],
      'model' => ['nullable'],
      'brand' => ['nullable'],
      'dimensions' => ['nullable'],
      'notes' => ['nullable'],
      'supplier_id' => ['nullable'],
    ]);

    $sid_array = array_unique($data['supplier_id']);
    

    $query = Machines::create([
      'name' => $data['name'],
      'status' => 1,
      'model' => $data['model'],
      'brand' => $data['brand'],
      'dimensions' => $data['dimensions'],
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
      return notifyRedirect($this->homeLink, 'Added a Machine successfully', 'success');
    }

  }






    public function show(Machines $machines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function edit(Machines $machines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machines $machines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machines $machines)
    {
        //
    }
}
