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
        Schema::create('mbg_laporan_harian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sekolah_id');
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->date('tanggal');
            $table->enum('kendala', [
                'Tidak Ada',
                'Terlambat',
                'Porsi Kurang'
            ])->default('Tidak Ada');

            $table->text('catatan')->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();
            // FK ke manajemen_sekolah
            $table->foreign('sekolah_id')
                ->references('id')
                ->on('manajemen_sekolah')
                ->onDelete('cascade');

            // FK ke mbg_menu
            $table->foreign('menu_id')
                ->references('id')
                ->on('mbg_menu')
                ->onDelete('set null');

            // 🔥 prevent double laporan per hari
            $table->unique(['sekolah_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mbg_laporan_harian');
    }
};