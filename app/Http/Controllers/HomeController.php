<?php

namespace App\Http\Controllers;

use App\Appsettings;
use App\Clients;
use App\Invoices;
use App\Projects;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;


class HomeController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {    
    //Settings
      $page_settings['seltab'] = 'dashboard'; 
      $user = auth()->user();
      $user->last_login = date('Y-m-d H:i:s');
      $user->update();

    //Stats
      $wsales = 0;
      $weekinvoices = Invoices::select("total",'clients_id')
        ->whereBetween('created_at', [Carbon::now()
        ->startOfWeek(), Carbon::now()->endOfWeek()])
        ->get();

      $msales = 0;
      $monthinvoices = Invoices::select("total")
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->get();


      foreach ($weekinvoices as $wi) {
        $wsales = $wsales + $wi->total;
      }

      foreach ($monthinvoices as $mi) {
        $msales = $msales + $mi->total;
      }

      $wclients = $weekinvoices->pluck('clients_id')->toArray();
      $wclients = array_unique($wclients);


    //Last 5 invoices
    $lastinvoices = Invoices::with('client')->latest()->take(5)->get();


    //Last 5 Projects
    $lastprojects = Projects::with('client')->orderBy('updated_at','desc')->take(5)->get();

    $sprojects = array( 
      '1' => 'Open', 
      '2' => 'Completed',
      '3' => 'Dropped'
    );

    $sinvoices = array( 
      '1' => 'Draft', 
      '2' => 'Sent',
      '3' => 'Paid'
    );


    return view('home', [
      "user"=>$user, 
      "page_settings"=>$page_settings,
      "winvoices" => count($weekinvoices),
      "wsales" => priceFormatFancy($wsales),
      "msales" => priceFormatFancy($msales),
      "wclients" => count($wclients),
      "lastinvoices" => $lastinvoices,
      "lastprojects" => $lastprojects,
      "sprojects" => $sprojects,
      "sinvoices" => $sinvoices
    ]);


  }
}
