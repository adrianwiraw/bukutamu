<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel groups dengan kolom yang SESUAI dengan Model Group
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();       // Diubah dari 'name' menjadi 'nama'
            $table->text('deskripsi')->nullable();    // Ditambahkan agar sesuai model
            $table->boolean('akses_penuh')->default(false); // Ditambahkan agar sesuai model
            $table->timestamps();
        });

        // 2. Buat tabel permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('groups');
    }
};