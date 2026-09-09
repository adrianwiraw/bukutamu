<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buku_tamu_id');
            $table->foreign('buku_tamu_id')
                ->references('id_pengunjung') // Primary key di tabel pengunjung
                ->on('pengunjung')            // Nama tabel yang benar
                ->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned()->default(0);
            $table->text('feedback')->nullable();
            $table->string('status')->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};