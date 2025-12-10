<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek dulu apakah tabel sudah ada
        if (!Schema::hasTable('winners')) {
            Schema::create('winners', function (Blueprint $table) {
                $table->id();
                $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
                $table->foreignId('submission_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('rank')->default(1);
                $table->decimal('prize_amount', 10, 2)->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('awarded_at')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->timestamps();
                
                // Indexes (jangan pakai unique dulu)
                $table->index('challenge_id');
                $table->index('user_id');
                $table->index('rank');
                $table->index('awarded_at');
            });
            
            // Tambahkan unique constraint secara terpisah SETELAH tabel dibuat
            Schema::table('winners', function (Blueprint $table) {
                $table->unique(['challenge_id', 'rank'], 'winners_challenge_rank_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};