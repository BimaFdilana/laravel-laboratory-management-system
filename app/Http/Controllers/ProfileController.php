<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Pastikan model User di-import

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        return view('pages.apps.profile.index', [
            'user' => Auth::user(),
            'type_menu' => ''
        ]);
    }

    // Memperbarui data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nim' => 'required|string|max:20|unique:users,nim,' . $user->id,
            'no_hp' => 'required|string|max:15',
            'jurusan' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'ktm_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Siapkan data untuk diupdate, kecuali password dan file
        $updateData = $request->except(['password', 'password_confirmation', 'ktm_path']);

        // Perbarui password jika diisi
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Proses upload file KTM
        if ($request->hasFile('ktm_path')) {
            // Hapus file lama jika ada
            if ($user->ktm_path) {
                Storage::delete('public/' . $user->ktm_path);
            }
            $path = $request->file('ktm_path')->store('public/ktm');
            $updateData['ktm_path'] = str_replace('public/', '', $path);
        }

        // Gunakan metode update()
        $user->update($updateData);

        return redirect()->route('home')->with('success', 'Profil berhasil diperbarui!');
    }
}
