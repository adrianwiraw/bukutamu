<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('buku_tamu_id');
            $table->foreign('buku_tamu_id')
                ->references('id_pengunjung')
                ->on('pengunjung')
                ->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned()->default(0);
            $table->text('feedback')->nullable();
            $table->string('status')->default('baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
