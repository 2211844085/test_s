<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\DeviceLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class AuthController extends Controller
{
    // Views
    public function showRegister()
    {
        return view('user.register');
    }
    public function showLogin()
    {
        return view('user.login');
    }

    // Logic
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'],
            'phone' => $data['phone'],
            'is_banned' => false,
            'company_name' => $data['company_name']
        ]);

        $user->notify('welcome');

        return redirect()->route('login');
    }
    public function registerAdmin(RegisterAdminRequest $request)
    {
        $data = $request->validated();
        
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'admin',
            'is_banned' => false,
            'phone' => $data['phone'],
            'company_name' => null
        ]);

        return redirect()->back();
    }
    public function login(LoginRequest $request)
    {
        $creds = $request->validated();

        if (Auth::attempt($creds)) {
            $request->session()->regenerate();

            $agent = new Agent();
            if ($agent->isMobile()) {
                $device = 'Mobile';
            } elseif ($agent->isTablet()) {
                $device = 'Tablet';
            } else {
                $device = 'Desktop';
            }
            DeviceLog::create([
                'device_type' => $device
            ]);

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'main' => 'Incorrect Email or Password'
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
