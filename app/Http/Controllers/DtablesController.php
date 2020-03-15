<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Redirect,Response,DB,Config;
use Yajra\Datatables\Datatables;



class DtablesController extends Controller
{
 
    public function index()
    {
    	$user = auth()->user();
        return view('datatables.index', ['user' => $user] );
    }

    public function usersList()
    {
        $users = DB::table('users')->select('*');
        return datatables()->of($users)
            ->make(true);
    }
}