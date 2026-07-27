<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mbbr_recipients', function (Blueprint $table) {
            $table->unsignedTinyInteger('decile')->nullable()->after('name');
            $table->string('condition')->nullable()->after('address');
            $table->string('provider_name')->nullable()->after('condition');
            $table->decimal('material_cost', 18, 2)->default(0)->after('provider_name');
            $table->decimal('labor_cost', 18, 2)->default(0)->after('material_cost');
            $table->decimal('material_progress', 5, 2)->default(0)->after('labor_cost');
            $table->decimal('labor_progress', 5, 2)->default(0)->after('material_progress');
            $table->decimal('material_remaining', 18, 2)->default(0)->after('labor_progress');
            $table->decimal('labor_remaining', 18, 2)->default(0)->after('material_remaining');
        });
    }
    public function down(): void
    {
        Schema::table('mbbr_recipients', function (Blueprint $table) {
            $table->dropColumn(['decile','condition','provider_name','material_cost','labor_cost','material_progress','labor_progress','material_remaining','labor_remaining']);
        });
    }
};
