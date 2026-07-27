<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('mbbr_program_types')->where('code', 'RTLH')->update([
            'code' => 'PEMBANGUNAN_PERUMAHAN',
            'name' => 'Pembangunan Perumahan',
            'description' => 'Program pembangunan dan penyediaan perumahan yang layak bagi masyarakat.',
            'updated_at' => now(),
        ]);
        foreach ([
            ['code' => 'KAWASAN_PERMUKIMAN', 'name' => 'Kawasan Permukiman', 'description' => 'Program penataan dan peningkatan kualitas kawasan permukiman.'],
            ['code' => 'PENINGKATAN_PSU', 'name' => 'Peningkatan PSU', 'description' => 'Program peningkatan prasarana, sarana, dan utilitas umum perumahan.'],
        ] as $type) {
            DB::table('mbbr_program_types')->updateOrInsert(['code' => $type['code']], $type + ['created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        DB::table('mbbr_program_types')->whereIn('code', ['KAWASAN_PERMUKIMAN', 'PENINGKATAN_PSU'])->delete();
        DB::table('mbbr_program_types')->where('code', 'PEMBANGUNAN_PERUMAHAN')->update(['code' => 'RTLH', 'name' => 'Bantuan Rumah Tidak Layak Huni', 'updated_at' => now()]);
    }
};
