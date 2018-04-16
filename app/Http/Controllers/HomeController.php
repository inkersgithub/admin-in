<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Roles;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role== Roles::ROLE_ADMIN){
            return redirect("/admin/dashboard");
        }
        else{
            return view('/');
        }
    }
}
