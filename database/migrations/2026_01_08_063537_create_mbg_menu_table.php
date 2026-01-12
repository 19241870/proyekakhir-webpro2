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
        Schema::create('mbg_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mbg_hari_id')
                  ->constrained('mbg_hari')
                  ->cascadeOnDelete();

            $table->foreignId('sekolah_id')
                  ->constrained('manajemen_sekolah')
                  ->cascadeOnDelete();

            $table->string('nama_menu', 100);
            $table->integer('kalori');
            $table->integer('protein');
            $table->boolean('is_active')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mbg_menu');
    }
};