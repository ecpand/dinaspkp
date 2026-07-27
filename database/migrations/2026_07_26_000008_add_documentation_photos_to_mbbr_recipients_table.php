<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void { Schema::table('mbbr_recipients', function (Blueprint $table) { $table->string('photo_initial_path')->nullable()->after('labor_remaining'); $table->string('photo_progress_path')->nullable()->after('photo_initial_path'); }); }
    public function down(): void { Schema::table('mbbr_recipients', function (Blueprint $table) { $table->dropColumn(['photo_initial_path','photo_progress_path']); }); }
};
