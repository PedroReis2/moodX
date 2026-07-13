<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use App\Http\Controllers\SketchbookController;

class DashboardController extends Controller
{
    public function dashboard(){
        if (Auth::user()->role_id == 1){
            $users = User::with('role')->get();
            return view('dashboard.dashboard-admin', compact('users'));
        }
        if (Auth::user()->role_id == 2){
            return app(SketchbookController::class)->dashboardTeacher();
        }
        if (Auth::user()->role_id == 3){
            return app(SketchbookController::class)->dashboard();
        }
    }
}
