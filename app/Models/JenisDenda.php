<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisDenda extends Model
{
    protected $table = 'jenis_denda';
    protected $primaryKey = 'id_jenis_denda';
    public $timestamps = false;

    protected $fillable = [
        'nama_denda',
        'nominal_denda',
        'keterangan_denda',
    ];

    protected $casts = [
        'nominal_denda' => 'integer',
    ];

    public function denda(): HasMany
    {
        return $this->hasMany(Denda::class, 'id_jenis_denda');
    }
}
