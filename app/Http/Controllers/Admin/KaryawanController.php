<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::orderBy('role')->orderBy('nama_lengkap')->get();
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('admin.karyawan.form', ['karyawan' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:karyawan,username',
            'email'        => 'required|email|unique:karyawan,email',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:admin,kasir_toko,staf_dapur',
        ]);

        Karyawan::create([
            'nama_lengkap'  => $data['nama_lengkap'],
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password_hash' => $data['password'],   // di-hash otomatis oleh model
            'role'          => $data['role'],
            'status_aktif'  => $request->boolean('status_aktif'),
        ]);

        return redirect()->route('admin.karyawan.index')->with('sukses', 'Karyawan ditambahkan');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('admin.karyawan.form', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => ['required', 'string', 'max:50',
                Rule::unique('karyawan', 'username')->ignore($karyawan->id_karyawan, 'id_karyawan')],
            'email'        => ['required', 'email',
                Rule::unique('karyawan', 'email')->ignore($karyawan->id_karyawan, 'id_karyawan')],
            'password'     => 'nullable|string|min:6',
            'role'         => 'required|in:admin,kasir_toko,staf_dapur',
        ]);

        $update = [
            'nama_lengkap' => $data['nama_lengkap'],
            'username'     => $data['username'],
            'email'        => $data['email'],
            'role'         => $data['role'],
            'status_aktif' => $request->boolean('status_aktif'),
        ];

        // password hanya diganti kalau diisi
        if (!empty($data['password'])) {
            $update['password_hash'] = $data['password'];
        }

        // admin tidak boleh menonaktifkan atau menurunkan role dirinya sendiri
        if ($karyawan->id_karyawan === auth('karyawan')->id()) {
            $update['status_aktif'] = true;
            $update['role'] = 'admin';
        }

        $karyawan->update($update);

        return redirect()->route('admin.karyawan.index')->with('sukses', 'Data karyawan diperbarui');
    }

    public function destroy(Karyawan $karyawan)
    {
        // Karyawan tidak dihapus karena sudah terkait produk dan pesanan, cukup dinonaktifkan.
        if ($karyawan->id_karyawan === auth('karyawan')->id()) {
            return back()->withErrors(['karyawan' => 'Kamu tidak bisa menonaktifkan akunmu sendiri']);
        }

        $karyawan->update(['status_aktif' => false]);

        return back()->with('sukses', 'Karyawan dinonaktifkan');
    }
}