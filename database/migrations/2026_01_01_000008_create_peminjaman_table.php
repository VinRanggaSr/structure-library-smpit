<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->enum('jenis_peminjaman', ['Harian', 'Semester']);
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_harus_kembali');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status_peminjaman', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa');
            $table->foreignId('id_item_buku')->constrained('item_buku', 'id_item_buku');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
