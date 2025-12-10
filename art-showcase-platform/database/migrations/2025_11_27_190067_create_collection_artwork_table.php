<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('collection_artwork', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('artwork_id');
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->unique(['collection_id', 'artwork_id']);
            $table->index(['collection_id']);
            $table->index(['artwork_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('collection_artwork');
    }
};