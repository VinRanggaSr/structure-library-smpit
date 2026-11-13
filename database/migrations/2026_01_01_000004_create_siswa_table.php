<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('NISN_siswa')->unique();
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin_siswa', ['Laki-laki', 'Perempuan']);
            $table->enum('status_siswa', ['Aktif', 'Tidak Aktif'])->default('Aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
