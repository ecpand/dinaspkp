<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rlth_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('survey_year')->nullable()->index();
            $table->string('name');
            $table->string('national_id', 32)->nullable()->index();
            $table->string('family_card_number', 32)->nullable();
            $table->string('phone', 40)->nullable();
            $table->text('address')->nullable();
            $table->string('regency_name')->nullable()->index();
            $table->string('village_name')->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('occupation')->nullable();
            $table->string('income_range')->nullable();
            $table->string('house_ownership')->nullable();
            $table->string('land_ownership')->nullable();
            $table->string('other_assets')->nullable();
            $table->string('foundation_condition')->nullable();
            $table->string('beam_column_condition')->nullable();
            $table->string('window_availability')->nullable();
            $table->string('ventilation_availability')->nullable();
            $table->string('mck_availability')->nullable();
            $table->string('water_source')->nullable();
            $table->string('wall_type')->nullable();
            $table->string('roof_material')->nullable();
            $table->string('roof_damage_level')->nullable()->index();
            $table->decimal('building_area', 10, 2)->nullable();
            $table->string('photo_front_path')->nullable();
            $table->string('photo_left_path')->nullable();
            $table->string('photo_right_path')->nullable();
            $table->string('photo_back_path')->nullable();
            $table->string('photo_roof_path')->nullable();
            $table->string('photo_window_path')->nullable();
            $table->string('photo_mck_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('rlth_records'); }
};
