<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_denda', function (Blueprint $table) {
            $table->id('id_jenis_denda');
            $table->string('nama_denda');
            $table->unsignedInteger('nominal_denda');
            $table->text('keterangan_denda')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_denda');
    }
};
