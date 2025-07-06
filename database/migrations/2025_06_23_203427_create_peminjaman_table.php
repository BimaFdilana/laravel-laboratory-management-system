<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('labor_id')->constrained('labors')->onDelete('cascade');
            $table->text('alasan');
            $table->dateTime('waktu_peminjaman');
            $table->dateTime('waktu_pemulangan')->nullable();
            $table->string('penanggung_jawab', 100);
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak', 'berjalan', 'selesai'])->default('diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
