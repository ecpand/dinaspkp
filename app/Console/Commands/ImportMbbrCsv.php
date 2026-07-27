<?php

namespace App\Console\Commands;

use App\Models\MbbrProgram;
use App\Models\MbbrProgramType;
use App\Models\MbbrRecipient;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ImportMbbrCsv extends Command
{
    protected $signature = 'mbbr:import-csv {file : Full path to the CSV file}';
    protected $description = 'Import data penerima MBBR from the approved CSV file';

    public function handle(): int
    {
        $file = $this->argument('file');
        if (!is_file($file) || !is_readable($file)) {
            $this->error('File CSV tidak dapat dibaca: '.$file);
            return self::FAILURE;
        }
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);
        if (!$header) throw new RuntimeException('Header CSV tidak ditemukan.');
        $header = array_map(fn ($column) => preg_replace('/^\xEF\xBB\xBF/', '', trim($column)), $header);
        $required = ['Tahun Anggaran','Nama Penerima Bantuan','Kabupaten/Kota','Nama Desa','Jenis Program','Sub Program','Status'];
        foreach ($required as $column) if (!in_array($column, $header, true)) throw new RuntimeException('Kolom wajib tidak ditemukan: '.$column);

        $types = MbbrProgramType::whereIn('code', ['PEMBANGUNAN_PERUMAHAN','KAWASAN_PERMUKIMAN','PENINGKATAN_PSU'])->get()->keyBy('code');
        $typeMap = ['1' => ['code'=>'PEMBANGUNAN_PERUMAHAN','prefix'=>'PP'], '2' => ['code'=>'KAWASAN_PERMUKIMAN','prefix'=>'KP'], '3' => ['code'=>'PENINGKATAN_PSU','prefix'=>'PSU']];
        $count = 0;

        DB::transaction(function () use ($handle, $header, $types, $typeMap, &$count) {
            while (($values = fgetcsv($handle)) !== false) {
                if (count($values) !== count($header)) continue;
                $row = array_combine($header, $values);
                $typeInfo = $typeMap[trim($row['Jenis Program'])] ?? null;
                if (!$typeInfo || !$types->has($typeInfo['code'])) continue;
                $year = (int) $row['Tahun Anggaran'];
                $subProgram = trim($row['Sub Program']) ?: 'Program MBBR';
                $type = $types[$typeInfo['code']];
                $code = $typeInfo['prefix'].'-'.$year.'-'.str($subProgram)->slug()->upper();
                $program = MbbrProgram::firstOrCreate(
                    ['mbbr_program_type_id'=>$type->id, 'fiscal_year'=>$year, 'name'=>$subProgram],
                    ['code'=>$code, 'budget'=>0, 'status'=>'planning', 'description'=>'Data MBBR impor tahun '.$year.'.']
                );
                $regency = Regency::firstOrCreate(['name'=>trim($row['Kabupaten/Kota'])]);
                $village = Village::firstOrCreate(['regency_id'=>$regency->id, 'name'=>trim($row['Nama Desa'])]);
                $status = match (strtolower(trim($row['Status']))) { 'selesai' => 'completed', 'proses' => 'process', default => 'waiting' };
                MbbrRecipient::updateOrCreate(
                    ['mbbr_program_id'=>$program->id, 'name'=>trim($row['Nama Penerima Bantuan'])],
                    ['regency_id'=>$regency->id, 'village_id'=>$village->id, 'decile'=>self::number($row['Desil']), 'companion_name'=>trim($row['Nama Pendamping Lapangan']), 'condition'=>trim($row['Kondisi']), 'provider_name'=>trim($row['Nama Toko / Penyedia Barang']), 'material_cost'=>self::money($row['Jumlah Biaya (Rp.)']), 'labor_cost'=>self::money($row['Jumlah Biaya (Rp.) Tahap 2']), 'material_progress'=>self::percent($row['Presentasi (%)']), 'labor_progress'=>self::percent($row['Presentasi (%) Tahap 2']), 'material_remaining'=>self::money($row['Sisa (Rp.)']), 'labor_remaining'=>self::money($row['Sisa (Rp.) Tahap 2']), 'latitude'=>self::decimal($row['Latitude']), 'longitude'=>self::decimal($row['Longitude']), 'progress'=>self::percent($row['Presentasi Progress Fisik (%)']), 'status'=>$status]
                );
                $count++;
            }
            MbbrProgram::query()->each(function (MbbrProgram $program) {
                $program->update(['budget' => $program->recipients()->selectRaw('COALESCE(SUM(material_cost + labor_cost), 0) as total')->value('total'), 'status' => $program->recipients()->where('status','!=','completed')->exists() ? 'active' : 'completed']);
            });
        });
        fclose($handle);
        $this->info("Impor selesai: {$count} baris penerima diproses.");
        return self::SUCCESS;
    }
    private static function money(?string $value): float { return (float) str_replace([',','Rp',' '], '', $value ?? '0'); }
    private static function percent(?string $value): float { return (float) str_replace('%', '', $value ?? '0'); }
    private static function decimal(?string $value): ?float { return is_numeric($value) ? (float) $value : null; }
    private static function number(?string $value): ?int { return is_numeric($value) ? (int) $value : null; }
}
