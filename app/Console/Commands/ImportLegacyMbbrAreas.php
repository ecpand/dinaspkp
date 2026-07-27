<?php

namespace App\Console\Commands;

use App\Models\MbbrArea;
use App\Models\Regency;
use Illuminate\Console\Command;

class ImportLegacyMbbrAreas extends Command
{
    protected $signature = 'mbbr:import-legacy-areas {source : GeoJSON JavaScript file or a legacy wilayah folder}';
    protected $description = 'Import legacy GeoJSON polygons into mbbr_areas';

    public function handle(): int
    {
        $source = $this->argument('source');
        $files = is_file($source) ? [$source] : glob(rtrim($source, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'Kawasan*.js');
        $count = 0;
        foreach ($files as $file) {
            $json = preg_replace('/^\s*var\s+\w+\s*=\s*/', '', file_get_contents($file));
            $collection = json_decode(rtrim(trim($json), ';'), true);
            if (!is_array($collection)) { $this->warn('Tidak dapat membaca: '.basename($file)); continue; }
            foreach ($collection['features'] ?? [] as $feature) {
                $geometry = $feature['geometry'] ?? null;
                if (!in_array($geometry['type'] ?? null, ['Polygon','MultiPolygon'], true)) continue;
                $properties = $feature['properties'] ?? [];
                $rawRegencyName = trim((string)($properties['WADMKK'] ?? $properties['Kab_Kota'] ?? $properties['KABKOT'] ?? $properties['kawasan'] ?? 'Maluku'));
                $regencyName = [
                    'KOTA AMBON' => 'Kota Ambon', 'BURU SELATAN' => 'Kabupaten Buru Selatan',
                    'MALUKU TENGAH' => 'Kabupaten Maluku Tengah', 'SERAM BAGIAN BARAT' => 'Kabupaten Seram Bagian Barat',
                    'SERAM BAGIAN TIMUR' => 'SBT',
                ][$rawRegencyName] ?? ucwords(strtolower($rawRegencyName));
                $regency = Regency::firstOrCreate(['name' => $regencyName]);
                $name = trim((string)($properties['Kawasan'] ?? $properties['kawasan'] ?? $properties['WADMKK'] ?? $properties['NAMOBJ'] ?? $properties['Kelurahan'] ?? basename($file, '.js')));
                if (!empty($properties['Kode_RT_RW'])) $name .= ' — '.trim((string) $properties['Kode_RT_RW']);
                MbbrArea::updateOrCreate(['name'=>$name, 'regency_id'=>$regency->id], ['geojson'=>$geometry]);
                $count++;
            }
        }
        $this->info("Impor selesai: {$count} polygon kawasan kumuh diproses.");
        return self::SUCCESS;
    }
}
