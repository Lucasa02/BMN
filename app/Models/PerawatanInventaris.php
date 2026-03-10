<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PerawatanInventaris extends Model
{
    use HasFactory;

    protected $table = 'perawatan_inventaris';

    protected $fillable = [
        'uuid',
        'barang_id',
        'user_id', // <-- WAJIB ditambahkan agar bisa menyimpan ID teknisi
        'tanggal_perawatan',
        'jenis_perawatan',
        'deskripsi',
        'status',
        'biaya',
        'foto_kerusakan',
        'foto_bukti',
        'surat_penghapusan'
    ];

    // Tambahkan ini agar UUID terisi otomatis
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid(); // Gunakan (string) agar pasti bertipe string
        });
    }

    public function barang()
    {
        return $this->belongsTo(BmnBarang::class, 'barang_id');
    }

    // RELASI BARU: Menghubungkan perawatan dengan Teknisi (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
