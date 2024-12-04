<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Hash;
use Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin) {
            return redirect()->route('welcome');
        }

        if ($admin && Hash::check($request->password, $admin->password)) {
            return redirect()->route('dashboard');  // Ganti dengan halaman dashboard
        } else {
            return back()->withErrors(['username' => 'Username atau password salah']);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin,username',
            'password' => 'required|confirmed|min:6',
        ]);

        Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
