<?php

namespace App\Http\Controllers;
use App\Logs;
use App\User;
use App\Tools;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;

class LogsController extends Controller
{
  private $page_settings;

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {

  }
  /**        //
  }
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
   * @param  \App\Logs  $logs
   * @return \Illuminate\Http\Response
   */
  public function show(Logs $logs)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Logs  $logs
   * @return \Illuminate\Http\Response
   */
  public function edit(Logs $logs)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Logs  $logs
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Logs $logs)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Logs  $logs
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $log = Logs::find($id);
    if($log){
      if(request()->ajax()){
        $row = Logs::where('id',$id)->delete();


        $latest_update = Logs::where('tool_id', $log->tool_id)->orderBy('updated_at', 'DESC')->first();

        $tool = Tools::find($latest_update->tool_id);
        $tool->status = $latest_update->status;
        $tool->update();

        return Response::json($row);
      }else{
        return notifyRedirect($this->homeLink, 'Unauthorized to delete', 'danger');
      }
    }else{
      return notifyRedirect($this->homeLink, 'Log not found', 'danger');
    }
  }
}
