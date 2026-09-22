<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mbbr_recipients', function (Blueprint $table) {
            $table->string('work_category', 20)->default('swakelola')->index()->after('mbbr_program_id');
            $table->string('area_status', 20)->nullable()->after('condition');
            $table->string('activity_program_name')->nullable()->after('area_status');
            $table->text('sub_activity_name')->nullable()->after('activity_program_name');
            $table->text('activity_location_name')->nullable()->after('sub_activity_name');
            $table->string('ppk_name')->nullable()->after('activity_location_name');
            $table->string('pptk_name')->nullable()->after('ppk_name');
            $table->string('contract_number')->nullable()->after('pptk_name');
            $table->date('contract_date')->nullable()->after('contract_number');
            $table->string('contractor_name')->nullable()->after('contract_date');
            $table->decimal('contract_value', 18, 2)->nullable()->after('contractor_name');
            $table->decimal('financial_progress', 5, 2)->nullable()->after('contract_value');
            $table->string('work_volume', 100)->nullable()->after('financial_progress');
            $table->string('work_unit', 50)->nullable()->after('work_volume');
        });
    }

    public function down(): void
    {
        Schema::table('mbbr_recipients', function (Blueprint $table) {
            $table->dropIndex(['work_category']);
            $table->dropColumn(['work_category', 'area_status', 'activity_program_name', 'sub_activity_name', 'activity_location_name', 'ppk_name', 'pptk_name', 'contract_number', 'contract_date', 'contractor_name', 'contract_value', 'financial_progress', 'work_volume', 'work_unit']);
        });
    }
};
