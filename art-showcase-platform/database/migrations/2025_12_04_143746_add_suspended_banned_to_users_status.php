<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Untuk MySQL
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'pending', 'suspended', 'banned') NOT NULL DEFAULT 'active'");
        
        // Untuk PostgreSQL (jika pakai PostgreSQL)
        // DB::statement("ALTER TABLE users ALTER COLUMN status TYPE VARCHAR(20)");
        // DB::statement("UPDATE users SET status = 'active' WHERE status NOT IN ('active', 'pending', 'suspended', 'banned')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum sebelumnya
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'pending') NOT NULL DEFAULT 'active'");
    }
};