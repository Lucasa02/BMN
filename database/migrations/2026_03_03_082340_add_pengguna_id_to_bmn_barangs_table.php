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
        Schema::table('bmn_barangs', function (Blueprint $table) {
        // Karena Pengguna menggunakan UUID, kita gunakan foreignUuid
        $table->foreignUuid('pengguna_id')->nullable()->after('ruangan')->constrained('penggunas', 'uuid')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bmn_barangs', function (Blueprint $table) {
        $table->dropForeign(['pengguna_id']);
        $table->dropColumn('pengguna_id');
    });
    }
};
