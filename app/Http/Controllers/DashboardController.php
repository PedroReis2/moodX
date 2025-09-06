<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        if (Auth::user()->role_id == 1){
            return view('dashboard.console');
        }
        if (Auth::user()->role_id == 2){
            return view('dashboard.hub');
        }
        if (Auth::user()->role_id == 3){
            return view('dashboard.dashboard');
        }
    }

}
