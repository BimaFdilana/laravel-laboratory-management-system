<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    /**
     * Atribut yang boleh diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'labor_id',
        'alasan',
        'waktu_peminjaman',
        'waktu_pemulangan',
        'penanggung_jawab',
        'status',
    ];

    /**
     * Atribut yang akan di-casting ke tipe data tertentu.
     * Membuat 'waktu_peminjaman' dan 'waktu_pemulangan' menjadi objek Carbon.
     */
    protected $casts = [
        'waktu_peminjaman' => 'datetime',
        'waktu_pemulangan' => 'datetime',
    ];

    /**
     * Relasi ke User.
     * Setiap Peminjaman dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Labor.
     * Setiap Peminjaman terkait dengan satu Labor.
     */
    public function labor(): BelongsTo
    {
        return $this->belongsTo(Labor::class);
    }
}