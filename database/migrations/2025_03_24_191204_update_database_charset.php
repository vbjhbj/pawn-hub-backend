<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER DATABASE laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci;");
        DB::statement("SET GLOBAL max_allowed_packet=67108864"); // 64 MB
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
