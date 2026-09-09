<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keperluan', function (Blueprint $table) {
            $table->id('id_keperluan'); // Primary key sesuai model
            $table->string('keperluan'); // Kolom utama sesuai model
            $table->timestamp('created')->nullable(); // Sesuai CREATED_AT di model
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keperluan');
    }
};