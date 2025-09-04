<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{

//___________________________________________________________ PAGES _____________________________________________________________\\


    public function welcome() {
        return view('welcome');
    }

    public function fallback(){
        return view("fallback.fallback");
    }


    //______________________________________________________ DADOS_____________________________________________________________\\

}
