<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    public const STATUS_BELUM_LUNAS = 'Belum Lunas';
    public const STATUS_LUNAS = 'Lunas';

    protected $table = 'denda';
    protected $primaryKey = 'id_denda';

    protected $fillable = [
        'jumlah_denda',
        'total_denda',
        'status_denda',
        'tanggal_bayar',
        'id_peminjaman',
        'id_jenis_denda',
    ];

    protected $casts = [
        'jumlah_denda' => 'integer',
        'total_denda' => 'integer',
        'tanggal_bayar' => 'date',
        'id_peminjaman' => 'integer',
        'id_jenis_denda' => 'integer',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function jenisDenda(): BelongsTo
    {
        return $this->belongsTo(JenisDenda::class, 'id_jenis_denda');
    }
}
