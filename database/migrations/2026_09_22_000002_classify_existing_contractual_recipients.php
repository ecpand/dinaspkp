<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('mbbr_recipients')
            ->join('mbbr_programs', 'mbbr_recipients.mbbr_program_id', '=', 'mbbr_programs.id')
            ->join('mbbr_program_types', 'mbbr_programs.mbbr_program_type_id', '=', 'mbbr_program_types.id')
            ->whereIn('mbbr_program_types.code', ['KP', 'PSU', 'KAWASAN_PERMUKIMAN', 'PENINGKATAN_PSU'])
            ->update(['mbbr_recipients.work_category' => 'kontraktual']);
    }

    public function down(): void
    {
        DB::table('mbbr_recipients')
            ->where('work_category', 'kontraktual')
            ->update(['work_category' => 'swakelola']);
    }
};
