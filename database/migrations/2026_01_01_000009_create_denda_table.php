<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->id('id_denda');
            $table->unsignedInteger('jumlah_denda');
            $table->unsignedInteger('total_denda');
            $table->enum('status_denda', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->date('tanggal_bayar')->nullable();
            // ERD: satu peminjaman punya paling banyak satu denda.
            $table->foreignId('id_peminjaman')->unique()->constrained('peminjaman', 'id_peminjaman')->cascadeOnDelete();
            $table->foreignId('id_jenis_denda')->constrained('jenis_denda', 'id_jenis_denda');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda');
    }
};
