<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('structural_officials', function (Blueprint $table) {
            $table->string('nip', 30)->nullable()->after('name');
            $table->string('unit')->nullable()->after('position');
            $table->string('education')->nullable()->after('echelon');
            $table->string('rank')->nullable()->after('education');
            $table->string('place_of_birth')->nullable()->after('rank');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->date('position_started_at')->nullable()->after('date_of_birth');
            $table->string('appointment_number')->nullable()->after('position_started_at');
            $table->text('education_history')->nullable()->after('bio');
            $table->text('career_history')->nullable()->after('education_history');
        });
    }

    public function down(): void
    {
        Schema::table('structural_officials', function (Blueprint $table) {
            $table->dropColumn(['nip', 'unit', 'education', 'rank', 'place_of_birth', 'date_of_birth', 'position_started_at', 'appointment_number', 'education_history', 'career_history']);
        });
    }
};
