<?php

namespace App\Http\Controllers;

use App\Models\Labor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaborController extends Controller
{
    public function index()
    {
        $labors = Labor::latest()->paginate(10);
        return view('pages.apps.admin.laboratorium.index', compact('labors'));
    }

    public function create()
    {
        return view('pages.apps.admin.laboratorium.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_labor' => 'required|string|max:255',
            'kapasitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'nullable|string|max:255',
            'asisten_labor' => 'nullable|string',
            'ketersediaan' => 'required|in:tersedia,tidak tersedia',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $labor = new Labor();
        $labor->nama_labor = $request->nama_labor;
        $labor->kapasitas = $request->kapasitas;
        $labor->deskripsi = $request->deskripsi;
        $labor->penanggung_jawab = $request->penanggung_jawab;
        $labor->asisten_labor = $request->asisten_labor;
        $labor->ketersediaan = $request->ketersediaan;

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('public/lab_images');
            $labor->image_path = str_replace('public/', '', $imagePath);
        }

        $labor->save();

        return redirect()->route('labors.index')->with('success', 'Laboratorium berhasil ditambahkan!');
    }

    public function show(Labor $labor)
    {
        // UBAH JALUR VIEW DI SINI (jika Anda membuat halaman show)
        return view('pages.apps.admin.laboratorium.show', compact('labor'));
    }

    public function edit(Labor $labor)
    {
        // UBAH JALUR VIEW DI SINI
        return view('pages.apps.admin.laboratorium.edit', compact('labor'));
    }

    public function update(Request $request, Labor $labor)
    {
        $request->validate([
            'nama_labor' => 'required|string|max:255',
            'kapasitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'nullable|string|max:255',
            'asisten_labor' => 'nullable|string',
            'ketersediaan' => 'required|in:tersedia,tidak tersedia',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $labor->nama_labor = $request->nama_labor;
        $labor->kapasitas = $request->kapasitas;
        $labor->deskripsi = $request->deskripsi;
        $labor->penanggung_jawab = $request->penanggung_jawab;
        $labor->asisten_labor = $request->asisten_labor;
        $labor->ketersediaan = $request->ketersediaan;

        if ($request->hasFile('image_path')) {
            if ($labor->image_path) {
                Storage::delete('public/' . $labor->image_path);
            }
            $imagePath = $request->file('image_path')->store('public/lab_images');
            $labor->image_path = str_replace('public/', '', $imagePath);
        }

        $labor->save();

        return redirect()->route('labors.index')->with('success', 'Laboratorium berhasil diperbarui!');
    }

    public function destroy(Labor $labor)
    {
        if ($labor->image_path) {
            Storage::delete('public/' . $labor->image_path);
        }

        $labor->delete();

        return redirect()->route('labors.index')->with('success', 'Laboratorium berhasil dihapus!');
    }
}