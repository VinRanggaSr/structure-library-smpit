<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    protected $table = 'aturan';
    protected $primaryKey = 'id_aturan';
    public $timestamps = false;

    protected $fillable = [
        'judul_aturan',
        'deskripsi_aturan',
    ];
}
