<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_data', function (Blueprint $table) {
            $table->string('data_source', 20)->nullable()->index()->after('source_number');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_data', function (Blueprint $table) {
            $table->dropIndex(['data_source']);
            $table->dropColumn('data_source');
        });
    }
};
