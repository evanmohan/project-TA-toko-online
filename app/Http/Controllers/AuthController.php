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
                $request->session()->regenerate();

                if (Auth::user()->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // 🔹 Jika ada redirect di query, arahkan ke sana
                if ($request->has('redirect')) {
                    return redirect()->to($request->query('redirect'));
                }

                // 🔹 Kalau tidak ada, arahkan ke halaman sebelumnya
                return redirect()->back();
            }

            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
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
            $request->validate([
                'username' => 'required|string|unique:users,username|max:50',
                'email' => 'required|email|unique:users,email',
                'no_hp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'password' => 'required|string|min:3|confirmed',
                'role' => 'in:admin,customer',
            ]);

            User::create([
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'customer',
            ]);

            // Setelah register, arahkan ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage()]);
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

        return redirect()->route(route: 'home');
    }
}
