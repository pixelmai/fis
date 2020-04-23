<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\Clients;
use App\Invoices;
use App\Invoiceitems;
use App\Machines;
use App\Services;
use App\Servicesrates;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;

class ReportsController extends Controller
{
  private $page_settings;

  public function __construct()
  {
  $this->middleware('auth');

  //Page repeated defaults
  $this->page_settings['seltab'] = 'reports';
  $this->page_settings['seltab2'] = 'monthly';
  $this->homeLink = '/reports';

  $this->status = array( 
    '1' => 'Draft', 
    '2' => 'Sent',
    '3' => 'Paid'
  );
  }

  public function monthly()
  {
  $user = auth()->user();
  $months = array( 
    '1' => 'January',
    '2' => 'February',
    '3' => 'March',
    '4' => 'April',
    '5' => 'May',
    '6' => 'June',
    '7' => 'July ',
    '8' => 'August',
    '9' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December',
  );

  if(request()->ajax()){



    $month = (isset($_GET['month']) ? $_GET['month'] : 0);
    $year = (isset($_GET['year']) ? $_GET['year'] : 0);

    $dbtable = Invoices::with('items','client','project')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();

    /*
    if($active_status == 0){
    
    }else{
    $dbtable = Invoices::with('items','client','project')->where('status', $active_status)->get();
    }
    */



  
    return datatables()->of($dbtable)
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
      return datetoDpicker($data->created_at);
    })
    ->addColumn('due_date', function($data){
      if($data->due_date){
      return datetoDpicker($data->due_date);
      }else{
      return '-';
      }
      
    })
    ->addColumn('id', function($data){
      return str_pad($data->id, 6, '0', STR_PAD_LEFT);
    })
    ->addColumn('status', function($data){
    if($data->status){
      $s = $this->status[$data->status];
    }

    return '<span class="status status_'.strtolower($s).'">'. $s .'</span>';
    })
    ->rawColumns(['status','total','client_name','company_name','project_name'])
    ->make(true);
    
  }

  return view('reports.monthly', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'months' => $months]);

  }
}
