<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('artwork_id');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->nullOnDelete();
            $table->text('content');
            $table->integer('likes_count')->default(0);
            $table->boolean('is_edited')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id']);
            $table->index(['artwork_id']);
            $table->index(['parent_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};