<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('artwork_id');
            $table->timestamps();
            
            $table->unique(['user_id', 'artwork_id']);
            $table->index(['user_id']);
            $table->index(['artwork_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};