<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    public const JENIS_HARIAN = 'Harian';
    public const JENIS_SEMESTER = 'Semester';
    public const STATUS_DIPINJAM = 'Dipinjam';
    public const STATUS_DIKEMBALIKAN = 'Dikembalikan';

    /** Hanya untuk tampilan: diturunkan dari tanggal, tidak ikut disimpan. */
    public const STATUS_TERLAMBAT = 'Terlambat';

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'jenis_peminjaman',
        'tanggal_peminjaman',
        'tanggal_harus_kembali',
        'tanggal_kembali',
        'status_peminjaman',
        'id_siswa',
        'id_item_buku',
        'id_pengguna',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_harus_kembali' => 'date',
        'tanggal_kembali' => 'date',
        'id_siswa' => 'integer',
        'id_item_buku' => 'integer',
        'id_pengguna' => 'integer',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function itemBuku(): BelongsTo
    {
        return $this->belongsTo(ItemBuku::class, 'id_item_buku');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class, 'id_peminjaman');
    }

    /** Hari lewat dari tanggal harus kembali — sampai tanggal kembali, atau sampai hari ini jika masih dipinjam. */
    protected function hariTerlambat(): Attribute
    {
        return Attribute::get(fn (): int => max(
            0,
            $this->tanggal_harus_kembali->diffInDays($this->tanggal_kembali ?? today(), false)
        ));
    }

    /** Status yang dilihat petugas: Terlambat adalah Dipinjam yang sudah lewat batas. */
    protected function statusTampilan(): Attribute
    {
        return Attribute::get(fn (): string => match (true) {
            $this->status_peminjaman === self::STATUS_DIKEMBALIKAN => self::STATUS_DIKEMBALIKAN,
            $this->hari_terlambat > 0 => self::STATUS_TERLAMBAT,
            default => self::STATUS_DIPINJAM,
        });
    }
}
