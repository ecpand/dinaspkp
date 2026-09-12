<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rlth_records', function (Blueprint $table) {
            $table->unique('family_card_number', 'rlth_records_family_card_number_unique');
        });
    }

    public function down(): void
    {
        Schema::table('rlth_records', function (Blueprint $table) {
            $table->dropUnique('rlth_records_family_card_number_unique');
        });
    }
};
