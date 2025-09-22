<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            'birth_date' => $request->birth_date,
            'avatar' => $photo,
        ]);

        return redirect()->route('login')->with('message', 'User created successfully');
    }

public function updateProfile(Request $request)
{

            //dd($request->all());

    $user = auth()->user();

    $request->validate([
        'email' => 'required|email|unique:users,email,' . $user->id,
        'birth_date' => 'nullable|date',
        'profile_image' => 'nullable|image',
    ]);

    $photo = null;

    if ($request->hasFile('profile_image')) {
        $photo = Storage::putFile('profile-pics', $request->profile_image);
    }

    // update user
    $user->update([
        'email' => $request->email,
    ]);

    // preparar dados do profile
    $profileData = [
        'birth_date' => $request->birth_date,
    ];

    if ($photo) {
        $profileData['avatar'] = $photo;
    }

    // update profile
    $user->profile()->update($profileData);

    return redirect()->route('profile')->with('message', 'User updated successfully');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Current password is incorrect',
        ]);
    }

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('profile')->with('message', 'Password updated successfully');
}

}
