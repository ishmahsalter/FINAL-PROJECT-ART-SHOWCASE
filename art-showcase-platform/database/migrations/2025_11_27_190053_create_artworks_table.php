<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('challenge_id')->nullable();
            
            // Basic Info
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('media_used')->nullable();
            
            // Image Info
            $table->string('image_path');  // Relative path di storage
            $table->string('image_url')->nullable();  // Full URL (optional)
            $table->string('thumbnail_url')->nullable();  // Thumbnail URL
            
            // Tags & Metadata
            $table->json('tags')->nullable();  // JSON array untuk tags
            $table->enum('visibility', ['public', 'private', 'unlisted'])->default('public');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            
            // Counters
            $table->integer('views')->default(0);
            $table->integer('views_count')->default(0);  // Untuk compatibility
            $table->integer('like_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('report_count')->default(0);
            
            // HAPUS VIRTUAL COLUMNS - ganti dengan regular columns
            $table->integer('likes_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->integer('comments_count')->default(0);
            
            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_approved')->default(true);
            
            // Timestamps
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['user_id']);
            $table->index(['category_id']);
            $table->index(['challenge_id']);
            $table->index(['status', 'visibility', 'is_approved']);
            $table->index(['published_at']);
            
            // Foreign key untuk challenge (optional)
            // $table->foreign('challenge_id')->references('id')->on('challenges')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};