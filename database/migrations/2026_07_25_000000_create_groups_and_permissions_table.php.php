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
        // 1. Buat tabel groups terlebih dahulu agar users tidak error!
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // sesuaikan jika ada kolom lain
            $table->timestamps();
        });

        // 2. Buat tabel permissions bawaan file ini
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