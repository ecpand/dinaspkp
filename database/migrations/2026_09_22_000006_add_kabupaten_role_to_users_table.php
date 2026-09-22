<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'editor', 'kabupaten') NOT NULL DEFAULT 'editor'");
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'kabupaten')->update(['role' => 'editor']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'editor') NOT NULL DEFAULT 'editor'");
    }
};
