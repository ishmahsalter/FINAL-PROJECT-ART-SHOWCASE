<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->string('reportable_type'); // App\Models\Artwork or App\Models\Comment
            $table->unsignedBigInteger('reportable_id');
            $table->text('reason');
            $table->enum('status', ['pending', 'dismissed', 'resolved'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
            
            // Index for polymorphic relation
            $table->index(['reportable_type', 'reportable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};