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
      $button = '<div class="hover_buttons"><a href="/bills/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';

      $button .= '<a href="/bills/view/'.$data->id.'/print" data-toggle="tooltip" data-placement="top" data-original-title="Print" class="edit btn btn-outline-secondary btn-sm" target="_blank"><i class="fas fa-print"></i></a>';

      if($data->status != 3){
        $button .= '<a href="javascript:void(0);" id="add-log-row" data-toggle="tooltip" data-placement="top" data-original-title="Set Status" data-id="'.$data->id.'"  class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-history"></i></a>';
      }

      if($data->status == 1){        
        $button .= '<a href="/bills/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

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



  public function select()
  {
    $user = auth()->user();

    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);



      $dbtable = Invoices::with('items','client','project')->get();
  
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

      ->addColumn('client_name', function($data){
        return $data->client->fname.' '.$data->client->lname;
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

          return $n;
        }else{
          return '-';
        }
      })


      ->addColumn('total', function($data){
        return '<div class="price">'. priceFormatFancy($data->total) .'</div>';
      })

      ->addColumn('created_at', function($data){
          return datetoDpicker($data->created_at);
      })
      ->addColumn('invoice_id', function($data){
          return '<div class="iid">'. str_pad($data->id, 6, '0', STR_PAD_LEFT) .'</div>';
      })
      ->addColumn('status', function($data){
        if($data->status){
          $s = $this->status[$data->status];
        }

        return '<span class="status status_'.strtolower($s).'">'. $s .'</span>';
      })
      ->rawColumns(['status','total','invoice_id'])
      ->make(true);
      
    }



    return view('bills.select', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'page_title'=> $this->page_title,  ]);
  }

  public function create($id)
  {
    $user = auth()->user();
    $invoice = Invoices::with('items')->find($id);
    $appsettings = Appsettings::find(1);
    $token = Str::random(60);

    if($invoice){
      $updater = User::find($invoice->updatedby_id);


      $invoice_items = array();

      foreach ($invoice->items as $key => $item) {
        $stat = Services::find($item->services_id);
        $r = Servicesrates::find($item->servicesrates_id);
        $price = ( $invoice->is_up == 1  ? $r->up_price : $r->def_price);

        $invoice_items[] = array( 
          "id" => $item->id,
          "services_id" => $stat->id,
          "services_name" => $stat->name,
          "quantity" => $item->quantity,
          "unit" => $stat->unit,
          "servicesrates_id" => $r->id,
          "price" => $price,
          "notes" => $item->notes,
        );
      }
            

      return view('bills.create', ['user' => $user, 'invoice' => $invoice, 'page_settings'=> $this->page_settings, 'updater' => $updater,  'status'=> $this->status, 'items' => $invoice_items, 'page_title'=> $this->page_title, 'appsettings' => $appsettings, 'dtoken' => $token]);
    

    }else{
      return notifyRedirect($this->homeLink, 'Invoice not found', 'danger');
    }
  }

  public function store()
  {
    $user = auth()->user();

    $data = request()->validate([
      'invoice_id' => ['required'],
      'for_name' => ['required'],
      'for_company' => ['nullable'],
      'for_position' => ['nullable'],
      'letter' => ['required'],
      'billing_date' => ['required'],
      'by_name' => ['required'],
      'by_position' => ['required'],
      'token_check' => ['required'],
    ]);


    $token_check = Officialbills::where('token', $data['token_check'])->first();

    $billing_date = (isset($data['billing_date']) ? dateDatabase($data['billing_date']) : $data['billing_date']);

    
    if(!$token_check){

      $query = Officialbills::create([
        'invoice_id' => $data['invoice_id'],
        'for_name' => $data['for_name'],
        'for_company' => $data['for_company'],
        'for_position' => $data['for_position'],
        'letter' => $data['letter'],
        'billing_date' => $billing_date,
        'by_name' => $data['by_name'],
        'by_position' => $data['by_position'],
        'status' => 1,
        'createdby_id' => $user->id,
        'updatedby_id' => $user->id,
        'token' => $data['token_check'],
      ]);

      if($query){
        return notifyRedirect($this->homeLink.'/view/'.$query->id, 'Added an Official Bill successfully', 'success');
      }


    }else{
      return notifyRedirect($this->homeLink.'/view/'.$token_check->id, 'Added an Official Bill successfully', 'success');
    }
  }


  public function view($id, $print = null)
  {
    $user = auth()->user();
    $bill = Officialbills::find($id);
    $invoice = Invoices::with('items')->find($bill->invoice_id);
    $appsettings = Appsettings::find(1);


    if($bill){
      $updater = User::find($bill->updatedby_id);
      if($bill->status){
        $s = $this->status[$bill->status];
      }

      $invoice_items = array();

      foreach ($invoice->items as $key => $item) {
        $stat = Services::find($item->services_id);
        $r = Servicesrates::find($item->servicesrates_id);
        $price = ( $invoice->is_up == 1  ? $r->up_price : $r->def_price);

        $invoice_items[] = array( 
          "id" => $item->id,
          "services_id" => $stat->id,
          "services_name" => $stat->name,
          "quantity" => $item->quantity,
          "unit" => $stat->unit,
          "servicesrates_id" => $r->id,
          "price" => $price,
          "notes" => $item->notes,
        );
      }
            
      if($print == 'print'){
        //TODO

        return view('bills.print', ['user' => $user, 'invoice' => $invoice, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s, 'status'=> $this->status, 'items' => $invoice_items, 'page_title'=> $this->page_title, 'bill' => $bill, 'appsettings'=> $appsettings]);
      }else{
        return view('bills.view', ['user' => $user, 'invoice' => $invoice, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s, 'status'=> $this->status, 'items' => $invoice_items, 'page_title'=> $this->page_title, 'bill' => $bill]);
      }

    }else{
      return notifyRedirect($this->homeLink, 'Invoice not found', 'danger');
    }
  }



  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Officialbills  $officialbills
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = auth()->user();
    $bill = Officialbills::find($id);
    $invoice = Invoices::with('items')->find($bill->invoice_id);
    $appsettings = Appsettings::find(1);


    if(isset($bill) && $bill->status == 1){

      $updater = User::find($invoice->updatedby_id);
      if($bill->status){
        $s = $this->status[$bill->status];
      }

      $invoice_items = array();

      foreach ($invoice->items as $key => $item) {
        $stat = Services::find($item->services_id);
        $r = Servicesrates::find($item->servicesrates_id);
        $price = ( $invoice->is_up == 1  ? $r->up_price : $r->def_price);

        $invoice_items[] = array( 
          "id" => $item->id,
          "services_id" => $stat->id,
          "services_name" => $stat->name,
          "quantity" => $item->quantity,
          "unit" => $stat->unit,
          "servicesrates_id" => $r->id,
          "price" => $price,
          "notes" => $item->notes,
        );
      }
            

      return view('bills.edit', ['user' => $user, 'invoice' => $invoice, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s, 'status'=> $this->status, 'items' => $invoice_items, 'page_title'=> $this->page_title, 'appsettings' => $appsettings, 'bill' => $bill]);

    }else{
      return notifyRedirect($this->homeLink, 'Invoice not found', 'danger');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Officialbills  $officialbills
   * @return \Illuminate\Http\Response
   */
  public function update($id)
  {
    $user = auth()->user();

    $bill = Officialbills::find($id);

    if($bill){

      $data = request()->validate([
        'for_name' => ['required'],
        'for_company' => ['nullable'],
        'for_position' => ['nullable'],
        'letter' => ['required'],
        'billing_date' => ['required'],
        'by_name' => ['required'],
        'by_position' => ['required'],
      ]);


      $billing_date = (isset($data['billing_date']) ? dateDatabase($data['billing_date']) : $data['billing_date']);

      $bill->for_name = $data['for_name'];
      $bill->for_company = $data['for_company'];
      $bill->for_position = $data['for_position'];
      $bill->letter = $data['letter'];
      $bill->billing_date = $billing_date;
      $bill->by_name = $data['by_name'];
      $bill->by_position = $data['by_position'];
      
      $query = $bill->update();

      if($query){
        return notifyRedirect($this->homeLink.'/view/'.$bill->id, 'Updated Official Bill #'. $bill->id .' successfully', 'success');
      }

    }else{
      return notifyRedirect($this->homeLink, 'Official Bill not found', 'danger');
    }

  }

  public function destroy($id)
  {
    $bill = Officialbills::find($id);

    if($bill && $bill->status == 1){
      if(request()->ajax()){
        $row = Officialbills::where('id',$id)->delete();
        
        sessionSetter('warning', 'Deleted Official Bill successufully');

        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Official Bill  not found', 'danger');
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

            $row = Officialbills::find($row_id); 
            if($row){
              $row->status = $form['status'];
              $row->updatedby_id = $form['updatedby_id'];
              $row->update();

              $count_updated++;
            }
        }
        return Response::json($count_updated);

      }else{

        $row = Officialbills::find($req_id); 
        if($row){
          $row->status = $form['status'];
          $row->updatedby_id = $form['updatedby_id'];
          $row->update();

          return Response::json(1);
        }
      }


    }else{
      return notifyRedirect($this->homeLink, 'Action not permitted', 'danger');
    }
  }


}
