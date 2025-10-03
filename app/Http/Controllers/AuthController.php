<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                return Auth::user()->role === 'admin'
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('user.dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses register
     */
    public function register(Request $request)
    {
        try {
            // dd($request->all());
            $request->validate([
                'username' => 'required|string|unique:users,username|max:50',
                'email' => 'required|email|unique:users,email',
                'no_hp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'password' => 'required|string|min:3|confirmed',
                'role' => 'in:admin,customer',
            ]);

            $user = User::create([
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'customer',
            ]);

            // Setelah register, langsung arahkan ke login
            return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login!');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
