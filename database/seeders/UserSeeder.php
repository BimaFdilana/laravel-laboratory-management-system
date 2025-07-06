<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema; // <-- TAMBAHKAN INI

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // --- BLOK BARU UNTUK TRUNCATE YANG AMAN ---
        // 1. Menonaktifkan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // 2. Truncate tabel users
        User::truncate();

        // 3. Mengaktifkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();
        // --- SELESAI BLOK TRUNCATE ---


        // Ambil ID peran dari database
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Buat Akun Admin
        User::create([
            'name' => 'Admin Aplikasi',
            'nim' => '0000000001',
            'email' => 'admin@pinlab.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password12345'),
            'role_id' => $adminRole->id,
            'prodi' => 'Administrasi Sistem',
            'no_hp' => '081200000001',
        ]);

        // Buat Akun User Biasa
        User::create([
            'name' => 'Budi Santoso',
            'nim' => '1234567890',
            'email' => 'budi@pinlab.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password12345'),
            'role_id' => $userRole->id,
            'prodi' => 'S1 Teknik Informatika',
            'no_hp' => '081234567890',
        ]);
    }
}