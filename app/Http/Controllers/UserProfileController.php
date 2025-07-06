<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $mahasiswas = User::where('role_id', 2)
            ->latest()
            ->paginate(10);

        // Mengirim data ke view
        return view('pages.apps.admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('pages.apps.admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:15',
            'jurusan' => 'required|string',
            'prodi' => 'required|string',
        ]);

        // Gunakan DB Transaction untuk memastikan semua query berhasil
        DB::beginTransaction();
        try {
            // Membuat user baru
            $user = new User();
            $user->name = $request->name;
            $user->nim = $request->nim;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // Enkripsi password
            $user->no_hp = $request->no_hp;
            $user->jurusan = $request->jurusan;
            $user->prodi = $request->prodi;
            $user->role_id = 3;

            $user->save();
            DB::commit();

            return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $mahasiswa = User::findOrFail($id);
        return view('pages.apps.admin.mahasiswa.edit', compact('mahasiswa'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'no_hp' => 'nullable|string|max:15',
            'jurusan' => 'required|string',
            'prodi' => 'required|string',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jurusan' => $request->jurusan,
            'prodi' => $request->prodi,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}