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
        Schema::table('manajemen_sekolah', function (Blueprint $table) {
            if (!Schema::hasColumn('manajemen_sekolah', 'kepala_sekolah')) {
                $table->string('kepala_sekolah')->nullable()->after('jumlah_porsi');
            }
            if (!Schema::hasColumn('manajemen_sekolah', 'jumlah_siswa')) {
                $table->integer('jumlah_siswa')->nullable()->after('kepala_sekolah');
            }
            if (!Schema::hasColumn('manajemen_sekolah', 'telepon')) {
                $table->string('telepon')->nullable()->after('jumlah_siswa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manajemen_sekolah', function (Blueprint $table) {
            $table->dropColumn(['kepala_sekolah', 'jumlah_siswa', 'telepon']);
        });
    }
};