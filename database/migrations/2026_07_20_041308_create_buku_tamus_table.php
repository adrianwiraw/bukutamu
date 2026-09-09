<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id('id_pengunjung');
            $table->string('identitas')->nullable();
            $table->integer('nomor')->default(0);
            $table->string('nama_pengunjung');
            $table->tinyInteger('id_jk')->default(1); // 1=Laki-laki, 2=Perempuan
            $table->integer('usia')->nullable();
            $table->string('nomortelepon')->nullable();
            $table->text('alamat_pengunjung')->nullable();
            $table->string('pejabat')->nullable();
            $table->text('keperluan_pengunjung');
            $table->string('jumlah')->default('1');
            $table->tinyInteger('status_konfirmasi')->default(0);
            $table->tinyInteger('status_respon')->default(0);
            $table->unsignedBigInteger('id_kebutuhan')->default(6);
            $table->timestamp('created')->nullable();
            
            // Kolom tambahan untuk form baru
            $table->string('no_hp')->nullable();
            $table->text('instansi_alamat')->nullable();
            $table->string('keperluan')->nullable();
            $table->string('nama')->nullable();
            $table->string('pegawai_temui')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('anda_sendirian')->nullable();
            $table->integer('jumlah_rombongan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
};