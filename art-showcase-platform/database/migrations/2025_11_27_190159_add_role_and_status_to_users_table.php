<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'member', 'curator'])->default('member')->after('email');
            $table->enum('status', ['active', 'pending'])->default('active')->after('role');
            $table->string('display_name')->nullable()->after('name');
            $table->text('bio')->nullable()->after('display_name');
            $table->string('profile_image')->nullable()->after('bio');
            $table->json('external_links')->nullable()->after('profile_image');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'display_name', 'bio', 'profile_image', 'external_links']);
        });
    }
};