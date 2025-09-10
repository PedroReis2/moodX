<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function storeuser(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'name' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // se adicionares password_confirmation no form
            'birthday' => 'required|date',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, // formando
        ]);

        return redirect()->route('welcome')->with('message', 'Utilizador criado com sucesso');
    }
}
