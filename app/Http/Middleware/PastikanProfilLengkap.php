<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PastikanProfilLengkap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Tentukan field mana saja yang wajib diisi
        $requiredFields = [
            'nim',
            'no_hp',
            'jurusan',
            'prodi'
        ];

        // Periksa setiap field yang wajib
        foreach ($requiredFields as $field) {
            // Jika ada satu saja field yang kosong (null atau string kosong)
            if (empty($user->{$field})) {
                // Alihkan pengguna ke halaman profil dengan pesan peringatan
                return redirect()->route('profile.index')
                    ->with('warning', 'Silakan lengkapi profil Anda terlebih dahulu sebelum melakukan peminjaman.');
            }
        }

        // Jika semua field sudah terisi, izinkan pengguna melanjutkan ke halaman tujuan
        return $next($request);
    }
}