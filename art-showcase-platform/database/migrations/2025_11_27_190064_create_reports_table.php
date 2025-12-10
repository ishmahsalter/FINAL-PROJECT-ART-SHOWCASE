<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel sudah ada, tidak perlu buat lagi
        // Cukup return untuk skip
    }

    public function down()
    {
        // Tidak perlu drop
    }
};