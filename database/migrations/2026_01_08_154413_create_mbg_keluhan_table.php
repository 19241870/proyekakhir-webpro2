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
        Schema::create('mbg_keluhan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('manajemen_sekolah')->cascadeOnDelete();
            $table->enum('kategori', [
                'Kualitas Makanan',
                'Keterlambatan',
                'Kurang',
                'Kebersihan',
                'Lainnya'
            ]);

            $table->text('deskripsi');

            $table->string('foto')->nullable();

            $table->enum('status', [
                'Belum Diproses',
                'Diproses',
                'Selesai'
            ])->default('Belum Diproses');

            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mbg_keluhan');
    }
};