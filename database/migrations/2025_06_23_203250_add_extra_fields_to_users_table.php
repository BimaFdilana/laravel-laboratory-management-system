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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp', 20)->nullable()->after('email');
            $table->string('jurusan')->nullable()->after('no_hp');
            $table->string('prodi')->nullable()->after('jurusan');
            $table->string('ktm_path')->nullable()->after('prodi'); // Menyimpan path ke file KTM
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'jurusan', 'prodi', 'ktm_path']);
        });
    }
};