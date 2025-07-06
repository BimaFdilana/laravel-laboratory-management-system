<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Labor;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class PeminjamanController extends Controller
{
    public function index()
    {
        $query = Peminjaman::with(['user', 'labor'])->latest();
        $user = Auth::user();

        // Ganti 'admin' dengan nama peran admin Anda jika berbeda
        if ($user->role->name != 'admin') {
            $query->where('user_id', $user->id);
        }

        $peminjamans = $query->paginate(10);
        return view('pages.apps.admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $labors = Labor::orderBy('nama_labor')->get();
        return view('pages.apps.admin.peminjaman.create', compact('labors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'labor_id' => 'required|exists:labors,id',
            'alasan' => 'required|string|min:10',
            'waktu_peminjaman' => 'required|date|after_or_equal:now',
            'penanggung_jawab' => 'required|string|max:255',
        ]);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'labor_id' => $request->labor_id,
            'alasan' => $request->alasan,
            'waktu_peminjaman' => $request->waktu_peminjaman,
            'penanggung_jawab' => $request->penanggung_jawab,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('home')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function updateStatus(Request $request, Peminjaman $peminjaman)
    {
        $request->validate(['status' => 'required|in:disetujui,ditolak,berjalan,selesai']);
        $newStatus = $request->status;

        if ($newStatus == 'disetujui') {
            $isConflict = Peminjaman::where('labor_id', $peminjaman->labor_id)
                ->where('waktu_peminjaman', $peminjaman->waktu_peminjaman)
                ->where('status', 'disetujui')
                ->where('id', '!=', $peminjaman->id)
                ->exists();

            if ($isConflict) {
                return redirect()->route('peminjaman.index')->with('error', 'Gagal menyetujui. Jadwal sudah terisi.');
            }
        }

        if ($newStatus == 'selesai') {
            $peminjaman->waktu_pemulangan = now();
        }

        $peminjaman->status = $newStatus;
        $peminjaman->save();

        $message = null;
        // Pastikan string status cocok (case-sensitive)
        switch ($newStatus) {
            case 'disetujui':
                $message = "Peminjaman lab {$peminjaman->labor->nama_labor} Anda telah disetujui. Silakan datang ke kampus dan temui penanggung jawab/asisten untuk mengambil kunci.";
                break;
            case 'ditolak':
                $message = "Mohon maaf, peminjaman lab {$peminjaman->labor->nama_labor} Anda ditolak.";
                break;
            case 'berjalan':
                $message = "Peminjaman lab {$peminjaman->labor->nama_labor} telah berjalan. Terima kasih.";
                break;
            case 'selesai':
                $message = "Peminjaman lab {$peminjaman->labor->nama_labor} telah selesai. Terima kasih.";
                break;
        }

        // Buat notifikasi jika ada pesan yang harus dikirim
        if ($message) {
            Notification::create([
                'user_id' => $peminjaman->user_id, // Pastikan ini mengirim ke user yang benar
                'message' => $message,
                'peminjaman_id' => $peminjaman->id,
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}
