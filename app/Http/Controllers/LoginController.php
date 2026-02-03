<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginModel;

class LoginController extends Controller
{
       // Form login
    public function showLoginForm() {
        return view('kasir.login');
    }

    // Proses login
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dash')->with('success', 'Login berhasil, selamat datang!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Form register
    public function showRegisterForm() {
        return view('kasir.register');
    }

    // Proses register
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|unique:admin',
            'password' => 'required|min:6',
        ]);

        LoginModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Logout
    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }


}
