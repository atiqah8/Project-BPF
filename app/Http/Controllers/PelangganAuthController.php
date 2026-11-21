<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganAuthController extends Controller
{
    public function showLogin()    { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email'          => 'required|email|unique:pelanggan,email',
            'no_whatsapp'    => 'required|string|max:20|unique:pelanggan,no_whatsapp',
            'password'       => 'required|min:6|confirmed',
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $data['nama_pelanggan'],
            'email'          => $data['email'],
            'no_whatsapp'    => $data['no_whatsapp'],
            'password_hash'  => $data['password'],
        ]);

        Auth::guard('pelanggan')->login($pelanggan);
        $request->session()->regenerate();

        return redirect()->route('katalog.index')->with('sukses', 'Pendaftaran berhasil, selamat datang!');
    }

    public function login(Request $request)
    {
        $kredensial = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('pelanggan')->attempt($kredensial, $request->boolean('ingat'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('katalog.index'));
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}