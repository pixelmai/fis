<?php

namespace App\Http\Controllers;
use App\User;
use App\Suppliers;
use App\Tools;
use Illuminate\Http\Request;

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
      $button = '<div class="hover_buttons"><a href="/suppliers/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/suppliers/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';
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
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function view($id)
  {
    $tools = Tools::find($id);
    return view('tools.view', compact('tools'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function edit(Tools $tools)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Tools $tools)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Tools  $tools
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tools $tools)
  {
    //
  }
}
