<?php

namespace Database\Seeders;

use App\Models\RlthRecord;
use Illuminate\Database\Seeder;

class RlthRecordSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            ['name'=>'Contoh RTLH Ambon 01','national_id'=>'8101000000000001','phone'=>'081200000001','address'=>'Jl. Piere Tendean','regency_name'=>'Kota Ambon','village_name'=>'Passo','latitude'=>-3.6394000,'longitude'=>128.2360000,'roof_damage_level'=>'Rusak Berat'],
            ['name'=>'Contoh RTLH Ambon 02','national_id'=>'8101000000000002','phone'=>'081200000002','address'=>'Desa Nania','regency_name'=>'Kota Ambon','village_name'=>'Nania','latitude'=>-3.6609000,'longitude'=>128.2073000,'roof_damage_level'=>'Rusak Sedang'],
            ['name'=>'Contoh RTLH SBB 01','national_id'=>'8102000000000001','phone'=>'081200000003','address'=>'Dusun Waimeteng','regency_name'=>'Seram Bagian Barat','village_name'=>'Piru','latitude'=>-3.0165000,'longitude'=>128.1857000,'roof_damage_level'=>'Rusak Ringan'],
            ['name'=>'Contoh RTLH SBB 02','national_id'=>'8102000000000002','phone'=>'081200000004','address'=>'Desa Kairatu','regency_name'=>'Seram Bagian Barat','village_name'=>'Kairatu','latitude'=>-3.3685000,'longitude'=>128.3429000,'roof_damage_level'=>'Rusak Berat'],
            ['name'=>'Contoh RTLH SBT 01','national_id'=>'8103000000000001','phone'=>'081200000005','address'=>'Desa Bula','regency_name'=>'Seram Bagian Timur','village_name'=>'Bula','latitude'=>-3.1133000,'longitude'=>130.4966000,'roof_damage_level'=>'Rusak Sedang'],
            ['name'=>'Contoh RTLH Maluku Tengah 01','national_id'=>'8104000000000001','phone'=>'081200000006','address'=>'Desa Masohi','regency_name'=>'Maluku Tengah','village_name'=>'Masohi','latitude'=>-3.3077000,'longitude'=>128.9674000,'roof_damage_level'=>'Rusak Ringan'],
            ['name'=>'Contoh RTLH Buru 01','national_id'=>'8105000000000001','phone'=>'081200000007','address'=>'Desa Namlea','regency_name'=>'Buru','village_name'=>'Namlea','latitude'=>-3.2696000,'longitude'=>126.7040000,'roof_damage_level'=>'Rusak Berat'],
            ['name'=>'Contoh RTLH Buru Selatan 01','national_id'=>'8106000000000001','phone'=>'081200000008','address'=>'Desa Namrole','regency_name'=>'Buru Selatan','village_name'=>'Namrole','latitude'=>-3.8639000,'longitude'=>126.7208000,'roof_damage_level'=>'Rusak Sedang'],
            ['name'=>'Contoh RTLH Kepulauan Aru 01','national_id'=>'8107000000000001','phone'=>'081200000009','address'=>'Kelurahan Galay Dubu','regency_name'=>'Kepulauan Aru','village_name'=>'Galay Dubu','latitude'=>-6.1773000,'longitude'=>134.3096000,'roof_damage_level'=>'Rusak Berat'],
            ['name'=>'Contoh RTLH Maluku Barat Daya 01','national_id'=>'8108000000000001','phone'=>'081200000010','address'=>'Desa Tiakur','regency_name'=>'Maluku Barat Daya','village_name'=>'Tiakur','latitude'=>-8.1914000,'longitude'=>127.7897000,'roof_damage_level'=>'Rusak Ringan'],
        ];

        foreach ($records as $index => $record) {
            RlthRecord::updateOrCreate(['national_id' => $record['national_id']], $record + [
                'survey_year' => 2026, 'family_card_number' => '8100'.str_pad((string) ($index + 1), 12, '0', STR_PAD_LEFT),
                'occupation' => $index % 2 ? 'Nelayan' : 'Petani', 'income_range' => '< Rp 2.000.000',
                'house_ownership' => 'Ya', 'land_ownership' => 'Ya', 'other_assets' => 'Tidak',
                'foundation_condition' => $index % 3 === 0 ? 'Rusak Berat' : 'Rusak Sedang',
                'beam_column_condition' => $index % 2 ? 'Rusak Sedang' : 'Rusak Ringan',
                'window_availability' => 'Tidak Ada', 'ventilation_availability' => 'Ada',
                'mck_availability' => 'Tidak Ada', 'water_source' => 'Sumur',
                'wall_type' => 'Kayu', 'roof_material' => 'Seng', 'building_area' => 36 + ($index * 3),
            ]);
        }
    }
}
