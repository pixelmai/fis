<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\Clients;
use App\Invoices;
use App\Invoiceitems;
use App\Officialbills;
use App\Projects;
use App\Services;
use App\Servicesrates;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

class OfficialbillsController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'transactions';
    $this->page_settings['seltab2'] = 'official';
    $this->homeLink = '/bills';
    $this->page_title = 'Official Bills';


    $this->status = array( 
      '1' => 'Draft', 
      '2' => 'Sent',
      '3' => 'Paid'
    );

  }
  
  /**
  protected $fillable = [
  'invoice_id', 'for_name', 'for_company', 'for_position', 'for_address', 
  'letter', 'billing_date', 'by_name', 'by_position', 'status', 'createdby_id', 'updatedby_id', 
  ];
   */

  public function index()
  {
  
    $user = auth()->user();


    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 0){
        $dbtable = Officialbills::with('invoice')->get();
      }else{
        $dbtable = Invoices::with('invoice')->where('status', $active_status)->get();
      }

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/invoices/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';

      $button .= '<a href="/invoices/view/'.$data->id.'/print" data-toggle="tooltip" data-placement="top" data-original-title="Print" class="edit btn btn-outline-secondary btn-sm" target="_blank"><i class="fas fa-print"></i></a>';

      if($data->status != 3){
        $button .= '<a href="javascript:void(0);" id="add-log-row" data-toggle="tooltip" data-placement="top" data-original-title="Set Status" data-id="'.$data->id.'"  class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-history"></i></a>';
      }

      if($data->status == 1){        
        $button .= '<a href="/invoices/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

        $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a>';
      }


      $button .= '</div>';

      return $button;
      })
      ->addColumn('checkbox', function($data){
        if($data->status != 3){
          return '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="'. $data->id .'" />';
        }else{
          return '&nbsp;';
        }
      })

      ->addColumn('total', function($data){
        return '<div class="price">'. priceFormatFancy($data->invoice->total) .'</div>';
      })

      ->addColumn('billing_date', function($data){
          return datetoDpicker($data->billing_date);
      })
      ->addColumn('invoice_id', function($data){
          return str_pad($data->invoice_id, 6, '0', STR_PAD_LEFT);
      })
      ->addColumn('status', function($data){
        if($data->status){
          $s = $this->status[$data->status];
        }

        return '<span class="status status_'.strtolower($s).'">'. $s .'</span>';
      })
      ->rawColumns(['checkbox','action','status','total'])
      ->make(true);
      
    }

    return view('bills.index', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'page_title'=> $this->page_title]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
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
   * @param  \App\Officialbills  $officialbills
   * @return \Illuminate\Http\Response
   */
  public function show(Officialbills $officialbills)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Officialbills  $officialbills
   * @return \Illuminate\Http\Response
   */
  public function edit(Officialbills $officialbills)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Officialbills  $officialbills
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Officialbills $officialbills)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Officialbills  $officialbills
   * @return \Illuminate\Http\Response
   */
  public function destroy(Officialbills $officialbills)
  {
    //
  }
}
