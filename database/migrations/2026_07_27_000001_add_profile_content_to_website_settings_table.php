<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('profile_tagline')->nullable()->after('short_name');
            $table->text('profile_direction')->nullable()->after('history');
            $table->json('profile_milestones')->nullable()->after('profile_direction');
            $table->json('service_scopes')->nullable()->after('profile_milestones');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['profile_tagline', 'profile_direction', 'profile_milestones', 'service_scopes']);
        });
    }
};
