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
        // Matikan pengecekan foreign key agar MySQL Docker tidak memicu error 1824
        Schema::disableForeignKeyConstraints();

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->boolean('aktif')->default(true);
        });

        // Hidupkan kembali pengecekan foreign key setelah selesai
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn(['group_id', 'aktif']);
        });
    }
};