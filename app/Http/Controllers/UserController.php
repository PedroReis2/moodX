<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function storeuser(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'birthday' => 'required|date',
            'profile_image' => 'image'
        ]);

        $photo = null;

        if ($request->hasFile('profile_image')) {
            $photo = Storage::putFile('profile-pics', $request->profile_image);
        }


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3, // formando
        ]);

        // criar profile
        $user->profile()->create([
            'birth_date' => $request->birthday,
            'avatar' => $photo,
        ]);

        return redirect()->route('login')->with('message', 'User created successfully');
    }
}
