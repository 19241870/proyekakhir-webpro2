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
        Schema::create('manajemen_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('foto')->nullable(); 
            // simpan path: sekolah/smk1.jpg

            $table->string('nama_sekolah');
            $table->string('npsn')->unique();

            $table->enum('jenjang', ['SD', 'SMP', 'SMA', 'SMK']);
            $table->enum('status', ['Negeri', 'Swasta']);

            $table->text('alamat');
            $table->string('kecamatan');

            $table->integer('jumlah_porsi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manajemen_sekolah');
    }
};