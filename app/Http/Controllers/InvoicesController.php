<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Invoices;
use App\Invoiceitems;
use App\Services;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

class InvoicesController extends Controller
{

  private $page_settings;

  public function __construct()
    {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'transactions';
    $this->page_settings['seltab2'] = 'invoices';
    $this->homeLink = '/invoices';

    $this->status = array( 
      '1' => 'Draft', 
      '2' => 'Sent',
      '3' => 'Paid'
    );

  }

  public function index()
  {
  
    $user = auth()->user();

    $ii_checker = Invoiceitems::where('invoices_id', 0)->get();

    if(count($ii_checker) > 0){
      Invoiceitems::where('invoices_id', 0)->delete();
    }


    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 0){
        $dbtable = Invoices::with('items','client','project')->get();
      }else{
        $dbtable = Invoices::with('items','client','project')->where('status', $active_status)->get();
      }

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/services/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/services/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

      $sum = 0;

      $activate_button = '<a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-success"><i class="fas fa-check"></i></a></div>';

      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
      ->addColumn('total', function($data){
        return '<div class="price">'. priceFormatFancy($data->total) .'</div>';
      })
      ->addColumn('client_name', function($data){
        return '<a href="/clients/view/'.$data->client->id.'">'.$data->client->fname.' '.$data->client->lname.'</a>';
      })
      ->addColumn('company_name', function($data){
        if($data->client->company){
          return '<a href="/companies/view/'.$data->client->company->id.'">'.$data->client->company->name.'</a>';
        }else{
          return '-';
        }
      })
      ->addColumn('project_name', function($data){
        if(isset($data->project) && $data->project->is_categorized == 1) {
          return '<a href="/projects/view/'.$data->project->id.'">'.$data->project->name.'</a>';
        }else{
          return ' '.$data->project->name.' ';
        }
      })
      ->addColumn('created', function($data){
          return dateOnly($data->created_at);
      })
      ->addColumn('due_date', function($data){
          return dateOnly($data->due_date);
      })
      ->rawColumns(['checkbox','action','total','client_name','company_name','project_name'])
      ->addColumn('status', function($data){
        if($data->status){
          $s = $this->status[$data->status];
        }
        return $s;
      })
      ->make(true);
      
    }
        
    return view('invoices.index', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status]);
  }


  public function create()
  {
    $user = auth()->user();
    $latest_invoice = Invoices::orderBy('created_at', 'desc')->select('id')->first();
    $id_num = $latest_invoice->id + 1;


    return view('invoices.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'id_num'=> $id_num]);
  }



/*
  protected $fillable = [
  'clients_id','companies_id', 'projects_id', 'machines_id', 'status', 'bill_type','is_up', 'discount', 'total', 'due_date','updatedby_id','is_saved'
  ];
*/


}
