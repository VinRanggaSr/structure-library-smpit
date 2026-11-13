<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemBuku extends Model
{
    public const STATUS_TERSEDIA = 'Tersedia';
    public const STATUS_DIPINJAM = 'Dipinjam';

    protected $table = 'item_buku';
    protected $primaryKey = 'id_item_buku';
    public $timestamps = false;

    protected $fillable = [
        'kode_buku',
        'status_buku',
        'tanggal_pembelian',
        'id_buku',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'id_buku' => 'integer',
    ];

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_item_buku');
    }
}
