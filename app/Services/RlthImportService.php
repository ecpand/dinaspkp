<?php

namespace App\Services;

use App\Models\RlthRecord;
use RuntimeException;
use ZipArchive;

class RlthImportService
{
    private const HEADER_MAP = [
        'tahun' => 'survey_year', 'tahun pendataan' => 'survey_year', 'nama' => 'name', 'nama penerima' => 'name',
        'nomor ktp' => 'national_id', 'nik' => 'national_id', 'nomor kk' => 'family_card_number', 'no hp' => 'phone', 'nomor hp' => 'phone',
        'alamat' => 'address', 'kelurahan desa' => 'village_name', 'desa' => 'village_name', 'kabupaten kota' => 'regency_name', 'kabupaten' => 'regency_name',
        'latitude' => 'latitude', 'lat' => 'latitude', 'longitude' => 'longitude', 'long' => 'longitude', 'lng' => 'longitude',
        'pekerjaan' => 'occupation', 'penghasilan' => 'income_range', 'status kepemilikan rumah' => 'house_ownership',
        'status kepemilikan tanah' => 'land_ownership', 'kepemilikan aset tempat lain' => 'other_assets',
        'kondisi pondasi rumah' => 'foundation_condition', 'kondisi pondasi' => 'foundation_condition',
        'kondisi balok dan kolom' => 'beam_column_condition', 'kondisi balok kolom' => 'beam_column_condition',
        'ketersediaan jendela' => 'window_availability', 'ketersediaan ventilasi' => 'ventilation_availability',
        'ketersediaan mck' => 'mck_availability', 'ketersediaan air bersih' => 'water_source', 'jenis dinding' => 'wall_type',
        'material atap' => 'roof_material', 'tingkat kerusakan atap' => 'roof_damage_level', 'luas bangunan' => 'building_area',
    ];

    public function import(string $path): array
    {
        $rows = $this->rows($path);
        if (count($rows) < 2) throw new RuntimeException('File tidak memiliki baris data.');

        $headers = array_map(fn ($header) => self::HEADER_MAP[$this->normalize((string) $header)] ?? null, array_shift($rows));
        if (!in_array('name', $headers, true)) throw new RuntimeException('Kolom Nama tidak ditemukan. Gunakan template RTLH yang benar.');

        $created = $updated = $skipped = 0;
        foreach ($rows as $row) {
            $data = [];
            foreach ($headers as $index => $field) if ($field && isset($row[$index]) && trim((string) $row[$index]) !== '') $data[$field] = trim((string) $row[$index]);
            if (blank($data['name'] ?? null)) { $skipped++; continue; }
            $data = $this->clean($data);
            $query = RlthRecord::query();
            if (!blank($data['national_id'] ?? null)) $query->where('national_id', $data['national_id']);
            else $query->where('name', $data['name'])->where('village_name', $data['village_name'] ?? null)->where('survey_year', $data['survey_year'] ?? null);
            $record = $query->first();
            if ($record) { $record->update($data); $updated++; } else { RlthRecord::create($data); $created++; }
        }
        return compact('created', 'updated', 'skipped');
    }

    private function clean(array $data): array
    {
        foreach (['survey_year', 'latitude', 'longitude', 'building_area'] as $field) {
            if (isset($data[$field])) $data[$field] = str_replace(',', '.', preg_replace('/[^0-9,.-]/', '', $data[$field]));
        }
        if (isset($data['survey_year'])) $data['survey_year'] = (int) $data['survey_year'];
        if (isset($data['building_area'])) $data['building_area'] = (float) $data['building_area'];
        if (isset($data['latitude'])) $data['latitude'] = (float) $data['latitude'];
        if (isset($data['longitude'])) $data['longitude'] = (float) $data['longitude'];
        return $data;
    }

    private function rows(string $path): array
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'csv' ? $this->csvRows($path) : $this->xlsxRows($path);
    }

    private function csvRows(string $path): array
    {
        $rows = []; $handle = fopen($path, 'r');
        while (($row = fgetcsv($handle, 0, ',')) !== false) $rows[] = $row;
        fclose($handle);
        return $rows;
    }

    private function xlsxRows(string $path): array
    {
        if (!class_exists(ZipArchive::class)) throw new RuntimeException('Ekstensi PHP ZipArchive belum aktif.');
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) throw new RuntimeException('File Excel tidak dapat dibaca.');
        $shared = [];
        if (($xml = $zip->getFromName('xl/sharedStrings.xml')) !== false) foreach (simplexml_load_string($xml)->si as $item) $shared[] = (string) $item->t ?: implode('', array_map('strval', iterator_to_array($item->r)));
        $sheet = $zip->getFromName('xl/worksheets/sheet1.xml'); $zip->close();
        if ($sheet === false) throw new RuntimeException('Lembar pertama pada Excel tidak ditemukan.');
        $rows = [];
        foreach (simplexml_load_string($sheet)->sheetData->row as $row) {
            $values = [];
            foreach ($row->c as $cell) {
                preg_match('/[A-Z]+/', (string) $cell['r'], $match); $column = $this->columnIndex($match[0] ?? 'A');
                $value = (string) $cell->v;
                if ((string) $cell['t'] === 's') $value = $shared[(int) $value] ?? '';
                if ((string) $cell['t'] === 'inlineStr') $value = (string) $cell->is->t;
                $values[$column] = $value;
            }
            if ($values) {
                $maxColumn = max(array_keys($values));
                $rows[] = array_map(fn ($column) => $values[$column] ?? '', range(0, $maxColumn));
            }
        }
        return $rows;
    }

    private function columnIndex(string $letters): int { $index = 0; foreach (str_split($letters) as $letter) $index = $index * 26 + ord($letter) - 64; return $index - 1; }
    private function normalize(string $value): string { return trim(preg_replace('/\s+/', ' ', preg_replace('/[^\pL\pN]+/u', ' ', mb_strtolower($value)))); }
}
