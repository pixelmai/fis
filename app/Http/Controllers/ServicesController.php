<?php

namespace App\Http\Controllers;

use App\User;
use App\Servcats;
use App\Services;
use App\Servicesrates;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Datatables;


class ServicesController extends Controller
{

  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');

    //Page repeated defaults
    $this->page_settings['seltab'] = 'transactions';
    $this->page_settings['seltab2'] = 'services';
    $this->homeLink = '/services';
  }


  
  public function index()
  {
  
    $user = auth()->user();


    if(request()->ajax()){

      $active_status = (isset($_GET['active_status']) ? $_GET['active_status'] : 0);


      if($active_status == 2){
        $dbtable = Services::with('current','category')->orderBy('name', 'ASC')->get();
      }else{
        $dbtable = Services::with('current','category')->orderBy('name', 'ASC')->where('is_deactivated', $active_status)->get();
      }

      return datatables()->of($dbtable)
        ->addColumn('action', function($data){
      $button = '<div class="hover_buttons"><a href="/services/view/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="View" class="edit btn btn-outline-secondary btn-sm"><i class="fas fa-eye"></i></a>';
      $button .= '<a href="/services/edit/'.$data->id.'" data-toggle="tooltip" data-placement="top" data-original-title="Edit" class="edit btn btn-outline-secondary btn-sm edit-post"><i class="fas fa-edit"></i></a>';

      $sum = 0;

      $activate_button = '<a href="javascript:void(0);" id="activate-row" data-toggle="tooltip" data-placement="top" data-original-title="Activate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-success"><i class="fas fa-check"></i></a></div>';


      if($sum == 0){
        if($data->is_deactivated == 1){
            $button .= $activate_button;
        }else{
            $button .= '<a href="javascript:void(0);" id="delete-row" data-toggle="tooltip" data-placement="top" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-trash"></i></a></div>';
        }
      }else{
        if($data->is_deactivated == 0){
          $button .= '<a href="javascript:void(0);" id="deactivate-row" data-toggle="tooltip" data-placement="top" data-original-title="Deactivate" data-id="'.$data->id.'" class="delete btn-sm btn btn-outline-danger"><i class="fas fa-ban"></i></a></div>';
        }else{
          $button .= $activate_button;
        }      
      }
      return $button;
      })
      ->addColumn('checkbox', '<input type="checkbox" name="tbl_row_checkbox[]" class="tbl_row_checkbox" value="{{$id}}" />')
      ->addColumn('dprice', function($data){
        $p = number_format(round($data->current->def_price,2), 2);
        return $p;
      })
      ->addColumn('uprice', function($data){
        $p = number_format(round($data->current->up_price,2), 2);
        return $p;
      })
      
      ->rawColumns(['checkbox','action'])
      ->make(true);
      
    }
        
    return view('services.index', ['user' => $user, 'page_settings'=> $this->page_settings]);


  }


} //end
 