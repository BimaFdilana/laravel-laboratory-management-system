<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Labor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = ['nama_labor', 'deskripsi', 'image_path', 'kapasitas', 'penanggung_jawab', 'asisten_labor', 'ketersediaan',];

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}