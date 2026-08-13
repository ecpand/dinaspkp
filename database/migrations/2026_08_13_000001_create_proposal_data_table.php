<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proposal_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('proposal_year')->index();
            $table->string('proposal_number')->nullable()->unique();
            $table->string('applicant_name');
            $table->string('applicant_phone', 40)->nullable();
            $table->string('institution_name')->nullable();
            $table->string('regency_name')->nullable()->index();
            $table->string('district_name')->nullable()->index();
            $table->string('village_name')->nullable()->index();
            $table->text('address')->nullable();
            $table->string('proposal_category')->nullable()->index();
            $table->string('proposal_type')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('beneficiary_count')->nullable();
            $table->decimal('estimated_budget', 18, 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('status')->default('submitted')->index();
            $table->text('verification_notes')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_data');
    }
};
