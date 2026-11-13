<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aturan', function (Blueprint $table) {
            $table->id('id_aturan');
            $table->string('judul_aturan');
            $table->text('deskripsi_aturan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aturan');
    }
};
