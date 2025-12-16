<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\PersonalInfoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Views
    public function showSettings()
    {
        return view('user.profile');
    }

    // Logic
    public function updateInfo(PersonalInfoRequest $request)
    {
        $info = $request->validated();

        $user = auth()->user();
        $user->email = $info['email'];
        $user->save();

        return redirect('/profile');
    }
    public function updateAccount(AccountRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();
        $user->username = $data['username'];
        if ($request->filled('password')) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect('/profile');
    }
    public function deleteAccount(Request $request)
    {
        auth()->user()->delete();

        return redirect('/');
    }
}
