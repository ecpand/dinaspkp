<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('proposal_data', function (Blueprint $table) {
            $table->unsignedInteger('source_number')->nullable()->after('id');
            $table->string('national_id', 32)->nullable()->index()->after('applicant_name');
            $table->string('family_card_number', 32)->nullable()->after('national_id');
            $table->string('dtsen_backlog', 50)->nullable()->after('family_card_number');
            $table->string('dtsen_decile', 50)->nullable()->after('dtsen_backlog');
            $table->string('province_name')->nullable()->after('dtsen_decile');
            $table->string('land_ownership_type')->nullable()->after('longitude');
            $table->text('ktp_file_url')->nullable()->after('land_ownership_type');
            $table->text('kk_file_url')->nullable()->after('ktp_file_url');
            $table->text('certificate_file_url')->nullable()->after('kk_file_url');
            $table->text('photo_front_url')->nullable()->after('certificate_file_url');
            $table->text('photo_back_url')->nullable()->after('photo_front_url');
            $table->text('photo_left_url')->nullable()->after('photo_back_url');
            $table->text('photo_right_url')->nullable()->after('photo_left_url');
            $table->text('photo_inside_url')->nullable()->after('photo_right_url');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_data', function (Blueprint $table) {
            $table->dropColumn([
                'source_number', 'national_id', 'family_card_number', 'dtsen_backlog', 'dtsen_decile',
                'province_name', 'land_ownership_type', 'ktp_file_url', 'kk_file_url',
                'certificate_file_url', 'photo_front_url', 'photo_back_url', 'photo_left_url',
                'photo_right_url', 'photo_inside_url',
            ]);
        });
    }
};
