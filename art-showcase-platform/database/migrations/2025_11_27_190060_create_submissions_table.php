<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'winner'])->default('pending');
            $table->text('feedback')->nullable();
            $table->integer('score')->nullable();
            $table->integer('winner_rank')->nullable();
            $table->timestamps();
            
            // Unique constraint: one submission per user per challenge
            $table->unique(['user_id', 'challenge_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('submissions');
    }
};