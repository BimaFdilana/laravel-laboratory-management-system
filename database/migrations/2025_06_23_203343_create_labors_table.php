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
        Schema::create('labors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_labor');
            $table->string('kapasitas');
            $table->text('deskripsi')->nullable();
            $table->string('penanggung_jawab')->nullable(); // Kolom teks biasa
            $table->text('asisten_labor')->nullable();     // Kolom teks biasa
            $table->enum('ketersediaan', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->string('image_path')->nullable();      // Path ke gambar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labors');
    }
};
