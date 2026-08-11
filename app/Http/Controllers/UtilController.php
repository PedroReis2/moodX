<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{

//___________________________________________________________ PAGES _____________________________________________________________\\


    public function fallback(){
        return view("fallback.fallback");
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    //______________________________________________________ DADOS_____________________________________________________________\\

}
