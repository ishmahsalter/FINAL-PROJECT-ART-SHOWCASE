<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            // CEK dulu kolom apa yang sudah ada dan apa yang belum
            if (!Schema::hasColumn('challenges', 'is_approved')) {
                $table->boolean('is_approved')->default(true)->after('status');
            }
            
            // TIDAK perlu prize_value karena sudah ada prize_pool
            // TIDAK perlu kolom prize karena sudah ada prize_pool
            
            // Tambahkan jika perlu field untuk draft status
            if (!Schema::hasColumn('challenges', 'is_draft')) {
                $table->boolean('is_draft')->default(false)->after('is_approved');
            }
        });
        
        // Update data existing
        DB::table('challenges')->update(['is_approved' => true]);
    }

    public function down(): void
    {
        Schema::table('challenges', function (Blueprint $table) {
            if (Schema::hasColumn('challenges', 'is_approved')) {
                $table->dropColumn('is_approved');
            }
            
            if (Schema::hasColumn('challenges', 'is_draft')) {
                $table->dropColumn('is_draft');
            }
        });
    }
};