<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rlth_records', function (Blueprint $table) {
            $table->string('submission_code', 32)->nullable()->unique()->after('id');
            $table->string('submission_status', 30)->default('verified')->index()->after('submission_code');
            $table->timestamp('submitted_at')->nullable()->after('submission_status');
            $table->string('province_name')->nullable()->after('address');
            $table->string('district_name')->nullable()->after('regency_name');
            $table->unsignedSmallInteger('family_member_count')->nullable()->after('family_card_number');
            $table->string('pln_customer_id')->nullable()->after('family_member_count');
            $table->unsignedTinyInteger('national_decile')->nullable()->after('pln_customer_id');
            $table->unsignedTinyInteger('provincial_decile')->nullable()->after('national_decile');
            $table->unsignedTinyInteger('regency_decile')->nullable()->after('provincial_decile');
            $table->string('national_pbi', 10)->nullable()->after('regency_decile');
            $table->string('local_pbi', 10)->nullable()->after('national_pbi');
            $table->string('floor_type')->nullable()->after('house_ownership');
            $table->string('electricity_source')->nullable()->after('water_source');
            $table->string('electricity_capacity')->nullable()->after('electricity_source');
            $table->string('cooking_fuel')->nullable()->after('electricity_capacity');
            $table->string('toilet_facility')->nullable()->after('cooking_fuel');
            $table->string('toilet_type')->nullable()->after('toilet_facility');
            $table->string('sewage_disposal')->nullable()->after('toilet_type');
            $table->timestamp('consented_at')->nullable()->after('photo_mck_path');
        });
    }

    public function down(): void
    {
        Schema::table('rlth_records', function (Blueprint $table) {
            $table->dropUnique(['submission_code']);
            $table->dropIndex(['submission_status']);
            $table->dropColumn(['submission_code', 'submission_status', 'submitted_at', 'province_name', 'district_name', 'family_member_count', 'pln_customer_id', 'national_decile', 'provincial_decile', 'regency_decile', 'national_pbi', 'local_pbi', 'floor_type', 'electricity_source', 'electricity_capacity', 'cooking_fuel', 'toilet_facility', 'toilet_type', 'sewage_disposal', 'consented_at']);
        });
    }
};
