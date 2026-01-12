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
        Schema::table('mbg_laporan_harian', function (Blueprint $table) {
            if (!Schema::hasColumn('mbg_laporan_harian', 'jam_lapor')) {
                $table->time('jam_lapor')->nullable()->after('tanggal');
            }

            if (!Schema::hasColumn('mbg_laporan_harian', 'jumlah_porsi')) {
                $table->integer('jumlah_porsi')->after('jam_lapor');
            }

            if (!Schema::hasColumn('mbg_laporan_harian', 'jumlah_sisa')) {
                $table->integer('jumlah_sisa')->default(0)->after('jumlah_porsi');
            }

            if (!Schema::hasColumn('mbg_laporan_harian', 'status')) {
                $table->enum('status', [
                    'Pending',
                    'Belum Verifikasi',
                    'Terverifikasi'
                ])->default('Pending')->after('jumlah_sisa');
            }

            if (!Schema::hasColumn('mbg_laporan_harian', 'rating')) {
                $table->string('rating', 5)->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mbg_laporan_harian', function (Blueprint $table) {
            $table->dropColumn([
                'jam_lapor',
                'jumlah_porsi',
                'jumlah_sisa',
                'status',
                'rating'
            ]);
        });
    }
};