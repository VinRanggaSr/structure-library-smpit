<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama_pengguna');
            $table->string('username_pengguna')->unique();
            $table->string('password_pengguna');
            $table->enum('role_pengguna', ['Superadmin', 'Penjaga']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
