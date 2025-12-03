<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Halaman edit profil
    public function edit()
    {
        $user = Auth::user();
    }

    // Update profil
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email',
            'no_hp'    => 'required|string|max:20',
            'alamat'   => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
