<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('judul_buku');
            $table->string('penulis_buku');
            $table->string('penerbit_buku')->nullable();
            $table->year('tahun_terbit_buku')->nullable();
            $table->unsignedInteger('stok_buku')->default(0);
            $table->foreignId('id_kategori')->constrained('kategori_buku', 'id_kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
