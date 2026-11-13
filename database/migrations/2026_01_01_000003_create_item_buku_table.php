<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_buku', function (Blueprint $table) {
            $table->id('id_item_buku');
            $table->string('kode_buku')->unique();
            $table->enum('status_buku', ['Tersedia', 'Dipinjam'])->default('Tersedia');
            $table->date('tanggal_pembelian')->nullable();
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_buku');
    }
};
