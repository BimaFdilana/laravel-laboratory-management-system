<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Labor;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = ['type_menu' => ''];

        // --- Data Statistik (Diambil untuk semua role) ---
        $data['totalLabor'] = Labor::count();
        $labTidakTersedia = Peminjaman::whereIn('status', ['disetujui', 'berjalan'])
            ->distinct()
            ->count('labor_id');
        $data['labTidakTersedia'] = $labTidakTersedia;
        $data['labTersedia'] = $data['totalLabor'] - $labTidakTersedia;
        $data['totalUser'] = User::where('role_id', '!=', 1)->count();


        // --- Data Konten (Berdasarkan role) ---
        if ($user->role_id == 1) { // Jika Admin
            $data['historyPeminjaman'] = Peminjaman::with(['user', 'labor'])
                ->latest()
                ->take(5)
                ->get();
        } else { // Jika User Biasa
            // Ambil semua notifikasi milik user, urutkan dari yang terbaru
            $data['userNotifications'] = $user->notifications()->latest()->paginate(3);

            // Ambil semua laboratorium
            $data['labors'] = Labor::orderBy('nama_labor')->get();

            // Ambil ID labor yang sedang tidak tersedia untuk pengecekan ketersediaan di view
            $data['bookedLabIds'] = Peminjaman::whereIn('status', ['disetujui', 'berjalan'])
                ->pluck('labor_id')
                ->unique()
                ->toArray();
        }

        return view('pages.apps.dashboard-admin', $data);
    }
}