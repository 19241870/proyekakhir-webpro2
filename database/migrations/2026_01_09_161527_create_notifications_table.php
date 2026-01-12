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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id')->nullable()
                  ->comment('Penerima notif (sekolah / admin)');

            $table->enum('role', ['admin', 'sekolah']);

            $table->string('type', 50)
                  ->comment('Contoh: keluhan');

            $table->string('title');
            $table->text('message');

            $table->string('link')->nullable();

            $table->boolean('is_read')->default(false);
            $table->index(['role', 'is_read']);
            $table->index('user_id');


            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};