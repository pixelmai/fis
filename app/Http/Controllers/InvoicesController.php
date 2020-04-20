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
      $button = '<div class="hover_buttons"><a href="/invoices/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';

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
        if($data->status == 1){
          return '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="'. $data->id .'" />';
        }else{
          return '&nbsp;';
        }
      })

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
          if($data->due_date){
            return datetoDpicker($data->due_date);
          }else{
            return '-';
          }
          
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

    $appsettings = Appsettings::find(1);
    $discounts = array( "dpwd" => $appsettings->dpwd, "dsc" => $appsettings->dsc);

    return view('invoices.create', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'id_num'=> $id_num, 'services' => $services, 'discounts' => $discounts]);
  }


  public function store()
  {

    $user = auth()->user();

    $data = request()->validate([
      'client_id' => ['required'],
      'company_id' => ['nullable'],
      'project_id' => ['nullable'],
      'status' => ['required'],
      'subtotal' => ['required'],
      'discount' => ['required'],
      'dtype' => ['required'],
      'total' => ['required'],
      'created_at' => ['required'],
      'due_date' => ['nullable'],
      'is_up' => ['nullable'],

      'services_id' => ['required'],
      'machines_id' => ['required'],
      'quantity' => ['required'],
      'notes' => ['nullable'],
    ]);

    $is_up = (isset($data['is_up']) && $data['is_up'] == 1 ? 1 : 0); 


    $services_id = $data['services_id'];
    $machines_id = $data['machines_id'];
    $quantity = $data['quantity'];
    $notes = $data['notes'];

    $now = date('m/d/Y');

    if(validateDate($data['created_at'])){
      if($data['created_at'] == $now ){
        
        $created_at = date("Y-m-d H:i:s");
      }else{
        $created_at = dateDatabase($data['created_at']);
      }
    }



    $due_date = (isset($data['due_date']) ? dateDatabase($data['due_date']) : $data['due_date']);

    $company_id = ($data['company_id'] == '' ? 1 : $data['company_id']); 

    
    $query = Invoices::create([
      'clients_id' => $data['client_id'],
      'companies_id' => $company_id,
      'projects_id' => $data['project_id'],
      'status' => $data['status'],
      'due_date' => $due_date,
      'subtotal' => priceFormatSaving($data['subtotal']),
      'discount' => $data['discount'],
      'discount_type' => $data['dtype'],
      'total' => priceFormatSaving($data['total']),
      'is_saved' => 0,
      'is_up' => $is_up,
      'updatedby_id' => $user->id,
      'created_at' => $created_at,
    ]);


    $k = 0;
    foreach($services_id as $service){
      $s = Services::with('current')->where('id',$service)->first();

      Invoiceitems::create([
        'invoices_id' => $query->id,
        'services_id' => $service,
        'servicesrates_id' => $s->servicesrates_id,
        'machines_id' => $machines_id[$k],
        'quantity' => $quantity[$k],
        'notes' => $notes[$k],
      ]);
      $k++;
    }

    
    $query->jobs = $k;
    $query->update();
    


    if($query){
      return notifyRedirect($this->homeLink.'/view/'.$query->id, 'Added an Invoice successfully', 'success');
    }

  }


  public function view($id)
  {
    $user = auth()->user();
    $invoice = Invoices::with('items')->find($id);

    if($invoice){
      $updater = User::find($invoice->updatedby_id);
      if($invoice->status){
        $s = $this->status[$invoice->status];
      }

      $invoice_items = array();

      foreach ($invoice->items as $key => $item) {
        $stat = Services::find($item->services_id);
        $r = Servicesrates::find($item->servicesrates_id);
        $m = Machines::find($item->machines_id);
        $price = ( $invoice->is_up == 1  ? $r->up_price : $r->def_price);

        $invoice_items[] = array( 
          "id" => $item->id,
          "services_id" => $stat->id,
          "services_name" => $stat->name,
          "quantity" => $item->quantity,
          "unit" => $stat->unit,
          "machines_id" => (isset($m->id) ? $m->id : 0),
          "machines_name" => (isset($m->name) ? $m->name : 0),
          "servicesrates_id" => $r->id,
          "price" => $price,
          "notes" => $item->notes,
        );
      }
            
      return view('invoices.view', ['user' => $user, 'invoice' => $invoice, 'page_settings'=> $this->page_settings, 'updater' => $updater, 's'=> $s, 'status'=> $this->status, 'items' => $invoice_items]);

    }else{
      return notifyRedirect($this->homeLink, 'Invoice not found', 'danger');
    }

  }


  public function edit($id)
  {
    $user = auth()->user();
    $invoice = Invoices::with('items')->find($id);

    if(isset($invoice) && $invoice->status == 1){

      $services = Services::with('current')->where('is_deactivated', 0)->get();
      $appsettings = Appsettings::find(1);
      $discounts = array( "dpwd" => $appsettings->dpwd, "dsc" => $appsettings->dsc);

      $invoice_current_data = array( 
        "company_name" => ($invoice->company->id == 1 ? '' : $invoice->company->name),
        "project_name" => ($invoice->project->is_categorized == 0 ? '' : $invoice->project->name),
        "due_date" => (!isset($invoice->due_date) ? '' : datetoDpicker($invoice->due_date)),
      );

      $invoice_items = array();
      $machines = array();

      foreach ($invoice->items as $key => $item) {
        $stat = Services::with('machines')->find($item->services_id);
        $r = Servicesrates::find($item->servicesrates_id);
        $m = Machines::find($item->machines_id);

        $price = ( $invoice->is_up == 1  ? $r->up_price : $r->def_price);


        if(count($stat->machines) != 0){
          foreach ($stat->machines as $key => $smachine){
            $machines[] = array(
              "service_id" => $stat->id,
              "smachine_id" => $smachine->id,
              "smachine_name" => $smachine->name,
            );
          }
        }else{
          $machines[] = array(
            "service_id" => $stat->id,
            "smachine_id" => 0,
            "smachine_name" => 'N/A',
          );
        }
        
        $amount = $price * $item->quantity;

        $invoice_items[] = array( 
          "id" => $item->id,
          "services_id" => $stat->id,
          "services_name" => $stat->name,
          "quantity" => $item->quantity,
          "unit" => $stat->unit,
          "machines_id" => (isset($m->id) ? $m->id : 0),
          "servicesrates_id" => $r->id,
          "up_price" => $r->up_price,
          "def_price" => $r->def_price,
          "price" => $price,
          "amount" => $amount,
          "notes" => $item->notes,
        );
      }

      return view('invoices.edit', ['user' => $user, 'page_settings'=> $this->page_settings, 'status' => $this->status, 'services' => $services, 'discounts' => $discounts, 'invoice' => $invoice, 'current_data' => $invoice_current_data, 'items' => $invoice_items, 'machines' => $machines]);


    }else{
      return notifyRedirect($this->homeLink, 'Invoice not found', 'danger');
    }
  }


  public function update($id)
  {
    $user = auth()->user();
    $invoice = Invoices::find($id);

    $data = request()->validate([
      'client_id' => ['required'],
      'company_id' => ['nullable'],
      'project_id' => ['nullable'],
      'status' => ['required'],
      'subtotal' => ['required'],
      'discount' => ['required'],
      'dtype' => ['required'],
      'total' => ['required'],
      'created_at' => ['required'],
      'due_date' => ['nullable'],
      'is_up' => ['nullable'],

      'currentid' => ['required'],
      'services_id' => ['required'],
      'machines_id' => ['required'],
      'quantity' => ['required'],
      'notes' => ['nullable'], 
    ]);


    $is_up = (isset($data['is_up']) && $data['is_up'] == 1 ? 1 : 0); 
    $company_id = ($data['company_id'] == '' ? 1 : $data['company_id']); 
    $due_date = (isset($data['due_date']) ? dateDatabase($data['due_date']) : $data['due_date']);
    
    $services_id = $data['services_id'];
    $machines_id = $data['machines_id'];
    $quantity = $data['quantity'];
    $notes = $data['notes'];


    $now = date('m/d/Y');

    if(validateDate($data['created_at'])){
      if($data['created_at'] == $now ){
        $created_at = date("Y-m-d H:i:s");
      }else{
        $created_at = dateDatabase($data['created_at']);
      }
    }

    $invoice->clients_id = $data['client_id'];
    $invoice->companies_id = $company_id;
    $invoice->projects_id = $data['project_id'];
    $invoice->status = $data['status'];
    $invoice->due_date = $due_date;
    $invoice->subtotal = priceFormatSaving($data['subtotal']);
    $invoice->discount = $data['discount'];
    $invoice->discount_type = $data['dtype'];
    $invoice->total = priceFormatSaving($data['total']);
    $invoice->is_saved = 0;
    $invoice->is_up = $is_up;
    $invoice->updatedby_id = $user->id;
    $invoice->created_at = $created_at;
    $invoice_query = $invoice->update();


    // INVOICE ITEM SAVES


    if($invoice_query){
      $old_items = $invoice->items->pluck('id')->toArray();
      $current_ids = array_map('intval', $data['currentid']);
      $add = array_diff($current_ids, $old_items);
      $remove = array_diff($old_items,$current_ids);
      $change = array_diff($old_items,$remove);



      $k = 0;
      foreach($data['currentid'] as $cl){
        $s = Services::with('current')->where('id',$services_id[$k])->first();

        if($cl != 0){
          $sitem = Invoiceitems::find($cl);
          
          $sitem->invoices_id = $invoice->id;
          $sitem->services_id = $services_id[$k];
          $sitem->servicesrates_id = $s->servicesrates_id;
          $sitem->machines_id = $machines_id[$k];
          $sitem->quantity = $quantity[$k];
          $sitem->notes = $notes[$k];
          $sitem->update();

        }elseif($cl == 0){
          Invoiceitems::create([
            'invoices_id' => $invoice->id,
            'services_id' => $services_id[$k],
            'servicesrates_id' => $s->servicesrates_id,
            'machines_id' => $machines_id[$k],
            'quantity' => $quantity[$k],
            'notes' => $notes[$k],
          ]);
        }
        $k++;
      }

      if(count($remove) != 0 ){
        $delete_rows = Invoiceitems::whereIn('id', $remove);
        $delete_rows->delete();
      }

      $new_item_count  = Invoices::find($id); //need to count new number
      $new_item_count->jobs = count($new_item_count->items);
      $new_item_count->update();

    }
    
    if($new_item_count){
      return notifyRedirect($this->homeLink.'/view/'.$id, 'Updated Invoice #'. $invoice->id .' successfully', 'success');
    }

  }


  public function destroy($id)
  {
    $invoice = Invoices::find($id);

    if($invoice && $invoice->status == 1){
      if(request()->ajax()){
        Invoiceitems::where('invoices_id',$id)->delete();
        $row = Invoices::where('id',$id)->delete();
        
        sessionSetter('warning', 'Deleted invoice successufully');

        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Invoice not found', 'danger');
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

            $row = Invoices::find($row_id); 
            if($row){
              $row->status = $form['status'];
              $row->updatedby_id = $form['updatedby_id'];
              $row->update();

              $count_updated++;
            }
        }
        return Response::json($count_updated);

      }else{

        $row = Invoices::find($req_id); 
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
