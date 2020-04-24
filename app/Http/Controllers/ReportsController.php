<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\Clients;
use App\Invoices;
use App\Invoiceitems;
use App\Machines;
use App\Regmsmes;
use App\Regtypes;
use App\Sectors;
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
    $this->homeLink = '/reports/monthly';

    $this->status = array( 
      '1' => 'Draft', 
      '2' => 'Sent',
      '3' => 'Paid'
    );

    $this->months = array( 
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

  }

  public function monthly()
  {
    $user = auth()->user();


    if(request()->ajax()){



      $month = (isset($_GET['month']) ? $_GET['month'] : 0);
      $year = (isset($_GET['year']) ? $_GET['year'] : 0);

      $dbtable = Invoices::with('items','client','project')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
      return datatables()->of($dbtable)

      ->addColumn('fancy_total', function($data){
        return '<div class="fancy_total price text-right">'. priceFormatFancy($data->total) .'</div>';
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
        return str_pad($data->id, 6, '0', STR_PAD_LEFT) . '<input type="" hidden class="total" value="'. $data->total .'">';
      })
      ->addColumn('status', function($data){
      if($data->status){
        $s = $this->status[$data->status];
      }

      return '<span class="status status_'.strtolower($s).'">'. $s .'</span>';
      })
      ->rawColumns(['status','id','fancy_total','client_name','company_name','project_name'])
      ->make(true);
      
    }

    return view('reports.monthly', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'months' => $this->months, 'page_title' => 'Monthly Reports']);
  }

  public function printmonthly($m, $y)
  {
    $user = auth()->user();
    
    $dbtable = Invoices::with('items','client','project')->whereMonth('created_at', $m)->whereYear('created_at', $y)->get();

    if(count($dbtable) != 0){

      $page_title = 'Monthly Report for '. $this->months[intval($m)] .', '. $y;

      if(request()->ajax()){
      
        return datatables()->of($dbtable)
        ->addColumn('subtotal', function($data){
          return '<div class="price text-right">'. priceFormatFancy($data->subtotal) .'</div>';
        })
        ->addColumn('discount', function($data){

          $up = ($data->is_up == 1 ? '(UP Rates) ' : '');

          if($data->discount_type != 0){
            $d = ($data->discount_type == 1 ? 'PWD: ' : 'SC: ');
          }else{
            $d = '';
          }

          if(intval($data->discount) != 0){
            $discount = $d . ($data->discount + 0) .'%';
          }else{
            $discount = '';
          }
          return '<div class="price text-right">'. $up .' '. $discount .'</div>';
        })

        ->addColumn('fancy_total', function($data){
          return '<div class="fancy_total price text-right">'. priceFormatFancy($data->total) .'</div>';
        })
        ->addColumn('client_name', function($data){
          return '<strong>' . $data->client->fname.' '.$data->client->lname. '</strong>';
        })
        ->addColumn('position', function($data){
          $p = (isset($data->client->position) ? $data->client->position : '-');
          return $p;
        })
        ->addColumn('company_name', function($data){
        if(isset($data->company) && $data->company->id != 1){

          $name = $data->company->name;
          if (strlen($name) >= 50) {
          $n = shortenText($name, 50);
          }
          else {
          $n = $name;
          }

          return $n;
        }else{
          return '-';
        }
        })
        ->addColumn('project_name', function($data){
        if(isset($data->project) && $data->project->is_categorized == 1) {
          $name = $data->project->name;
          if (strlen($name) >= 50) {
          $n = shortenText($name, 50);
          }
          else {
          $n = $name;
          }

          return $n;
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
          return str_pad($data->id, 6, '0', STR_PAD_LEFT) . '<input type="" hidden class="total" value="'. $data->total .'">';
        })
        ->addColumn('food', function($data){
          $food = ($data->client->is_food == 1 ? '<div class="text-center">FOOD</div>' : '');
          return $food;
        })
        ->addColumn('jobs', function($data){
          return '<div class="text-center">' . $data->jobs .'</div>';
        })
        ->addColumn('sector', function($data){
          $sector = Sectors::find($data->client->sector_id);
          return '<div class="text-center">' . $sector->name .'</div>';
        })
        ->addColumn('msme', function($data){
          $regtype = Regtypes::find($data->client->regtype_id);
          $regmsme = Regmsmes::find($regtype->regmsmes_id);

          return '<div class="text-center">' . $regtype->name .' <em>('. $regmsme->name .')</em></div>';
        })
        ->addColumn('male', function($data){
          $gender = ($data->client->gender == 'm' ? '<div class="text-center">X</div>' : '');
          return $gender;
        })
        ->addColumn('female', function($data){
          $gender = ($data->client->gender == 'f' ? '<div class="text-center">X</div>' : '');
          return $gender;
        })
        ->addColumn('youth', function($data){
          if(isset($data->client->date_of_birth)){
            $age = date_diff(date_create($data->client->date_of_birth), date_create('today'))->y;

            $y = ( $age <= 18 ? '<div class="text-center">X</div>' : '');
            return $y;
          }else{
            return '';
          }
        })
        ->addColumn('sc', function($data){
          if(isset($data->client->date_of_birth)){
            $age = date_diff(date_create($data->client->date_of_birth), date_create('today'))->y;

            $y = ( $age >= 60 ? '<div class="text-center">X</div>' : '');
            return $y;
          }else{
            return '';
          }
        })
        ->addColumn('pwd', function($data){
          $pwd = ($data->client->is_pwd == 1 ? '<div class="text-center">X</div>' : '');
          return $pwd;
        })
        ->rawColumns(['id','food','pwd','sc','youth','male','female','discount','msme','sector','jobs','subtotal','fancy_total','client_name','company_name','project_name'])
        ->make(true);
        
      }

      return view('reports.printmonthly', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'page_title' => $page_title, 'm' => $m, 'y' => $y, 'months' => $this->months]);
    }else{
      return notifyRedirect($this->homeLink, 'Invalid dates', 'danger');
    }
  }



}
