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
    public function storeUser(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'birth_date' => 'required|date',
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

        return redirect()->route('dashboard')->with('message', 'User created successfully');
    }

    public function storeUserByAdmin(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'role_id'=> 'required'
        ]);


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make("User123"),
            'role_id' => $request->role_id,
        ]);

        // criar profile
        $user->profile()->create([
        ]);

        return redirect()->route('dashboard')->with('message', 'User created successfully');
    }


public function updateUserByAdmin(Request $request)
{
    $user = User::findOrFail($request->user_id);

    $request->validate([
        'first_name' => 'required|string|max:50',
        'last_name' => 'required|string|max:50',
        'username' => 'required|string|max:50|unique:users,name,' . $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role_id'=> 'required'
    ]);

    $user->update([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'name'       => $request->username,
        'email'      => $request->email,
        'role_id'    => $request->role_id,
    ]);

    return redirect()->route('dashboard')->with('message', 'User updated successfully');
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


public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->id == Auth::user()->id)
        return back()->withErrors([
            'You cannot delete yourself',
        ]);

    $user->delete();
    return redirect()->back()->with('message', 'User deleted successfully.');
}

public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    $user->status = !$user->status;
    $user->save();

    return redirect()->route('dashboard')
        ->with('message', 'User status updated successfully');
}

}
