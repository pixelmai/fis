<?php

namespace App\Http\Controllers;

Use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


class AccountsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(User $user)
    {

        return view('accounts.index', compact('user'));

    }
}
