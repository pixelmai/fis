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
        if(isset($data->company) && $data->company->id != 1){

          $name = $data->company->name;
          if (strlen($name) >= 30) {
            $n = shortenText($name, 30);
          }
          else {
            $n = $name;
          }

          return '<a href="/companies/view/'.$data->company->id.'">'.$n.'</a>';
        }else{
          return '-';
        }
      })
      ->addColumn('project_name', function($data){
        if(isset($data->project) && $data->project->is_categorized == 1) {
          $name = $data->project->name;
          if (strlen($name) >= 20) {
            $n = shortenText($name, 20);
          }
          else {
            $n = $name;
          }

          return '<a href="/projects/view/'.$data->project->id.'">'.$n.'</a>';
        }else{
          return '-';
        }
      })
      ->addColumn('created', function($data){
          return dateTimeFormatSimple($data->created_at);
      })
      ->addColumn('due_date', function($data){
          return datetoDpicker($data->due_date);
      })
      ->addColumn('id', function($data){
          return str_pad($data->id, 6, '0', STR_PAD_LEFT);
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

    $lid = (isset($latest_invoice->id) ? $latest_invoice->id : 0);
    $id_num = $lid + 1;

    $services = Services::with('current')->where('is_deactivated', 0)->get();


    return view('invoices.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'id_num'=> $id_num, 'services' => $services]);
  }


  public function store()
  {

    $user = auth()->user();

    $data = request()->validate([
      'client_id' => ['required'],
      'company_id' => ['nullable'],
      'project_id' => ['nullable'],
      'status' => ['required'],
      'discount' => ['nullable'],
      'total' => ['required'],
      'created_at' => ['required'],
      'due_date' => ['nullable'],
      'is_up' => ['nullable'],
    ]);



    $is_up = (isset($data['is_up']) && $data['is_up'] == 1 ? 1 : 0); 

    if(validateDate($data['created_at'])){
      if($data['created_at'] == date('m/d/Y')){
        $created_at = date("Y-m-d H:i:s");
      }else{
        $created_at = $data['created_at'];
      }
    }



    $due_date = (isset($data['due_date']) ? dateDatabase($data['due_date']) : $data['due_date']);

    $company_id = ($data['company_id'] == '' ? 1 : $data['company_id']); 


    $query = Invoices::create([
      'clients_id' => $data['client_id'],
      'companies_id' => $company_id,
      'projects_id' => $data['project_id'],
      'status' => $data['status'],
      'created_at' => $created_at,
      'due_date' => $due_date,
      'discount' => $data['discount'],
      'total' => priceFormatSaving($data['total']),
      'is_saved' => 0,
      'is_up' => $is_up,

      'updatedby_id' => $user->id,
    ]);


    if($query){
      return notifyRedirect($this->homeLink, 'Added an Invoice successfully', 'success');
    }

  }



/*
  protected $fillable = [
  'clients_id','companies_id', 'projects_id', 'machines_id', 'status', 'bill_type','is_up', 'discount', 'total', 'due_date','updatedby_id','is_saved'
  ];
*/


}
