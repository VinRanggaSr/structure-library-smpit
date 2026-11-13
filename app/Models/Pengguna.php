<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    public const ROLE_SUPERADMIN = 'Superadmin';
    public const ROLE_PENJAGA = 'Penjaga';

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;

    protected $fillable = [
        'nama_pengguna',
        'username_pengguna',
        'password_pengguna',
        'role_pengguna',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_pengguna');
    }

    public function getAuthPassword(): string
    {
        return $this->password_pengguna;
    }
}
