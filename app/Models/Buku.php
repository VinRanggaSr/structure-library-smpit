<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;

    protected $fillable = [
        'judul_buku',
        'penulis_buku',
        'penerbit_buku',
        'tahun_terbit_buku',
        'stok_buku',
        'id_kategori',
    ];

    protected $casts = [
        'tahun_terbit_buku' => 'integer',
        'stok_buku' => 'integer',
        'id_kategori' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori');
    }

    public function itemBuku(): HasMany
    {
        return $this->hasMany(ItemBuku::class, 'id_buku');
    }
}
