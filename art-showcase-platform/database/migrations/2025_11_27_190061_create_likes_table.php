<?php
// database/migrations/2025_11_27_190061_create_likes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // PERBAIKI: Hapus satu $ ekstra!
            $table->unsignedBigInteger('artwork_id'); // <-- INI YANG BENAR
            
            $table->timestamps();
            
            $table->unique(['user_id', 'artwork_id']);
            $table->index(['user_id']);
            $table->index(['artwork_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};