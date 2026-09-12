<?php

namespace App\Http\Controllers;

use App\Models\RlthRecord;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PublicRlthSubmissionController extends Controller
{
    private const MALUKU_REGENCIES = [
        'Kota Ambon', 'Kota Tual', 'Kabupaten Buru', 'Kabupaten Buru Selatan',
        'Kabupaten Kepulauan Aru', 'Kabupaten Maluku Barat Daya', 'Kabupaten Maluku Tengah',
        'Kabupaten Maluku Tenggara', 'Kabupaten Kepulauan Tanimbar',
        'Kabupaten Seram Bagian Barat', 'Kabupaten Seram Bagian Timur',
    ];

    private const PHOTO_FIELDS = [
        'photo_front' => 'photo_front_path',
        'photo_left' => 'photo_left_path',
        'photo_right' => 'photo_right_path',
        'photo_back' => 'photo_back_path',
        'photo_roof' => 'photo_roof_path',
        'photo_window' => 'photo_window_path',
        'photo_mck' => 'photo_mck_path',
    ];

    public function create()
    {
        return view('frontend.pages.services.rlth-public-form', [
            'page' => 'form-pendataan-rtlh',
            'title' => 'Pendataan RTLH',
            'setting' => WebsiteSetting::first(),
            'malukuRegencies' => self::MALUKU_REGENCIES,
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'survey_year' => now()->year,
            'family_card_number' => preg_replace('/\D+/', '', (string) $request->input('family_card_number')),
            'national_id' => preg_replace('/\D+/', '', (string) $request->input('national_id')),
        ]);

        $rules = [
            'survey_year' => 'required|integer|min:2000|max:2100',
            'province_name' => 'required|in:Maluku',
            'regency_name' => ['required', Rule::in(self::MALUKU_REGENCIES)],
            'district_name' => 'required|string|max:255',
            'village_name' => 'required|string|max:255',
            'address' => 'required|string|max:2000',
            'family_card_number' => 'required|digits:16|unique:rlth_records,family_card_number',
            'head_of_family_name' => 'required|string|max:255',
            'national_id' => 'required|digits:16',
            'phone' => 'required|string|max:40',
            'occupation' => 'required|string|max:255',
            'income_range' => 'required|in:< 2.000.000,2.000.000 - 5.000.000,> 5.000.000',
            'family_member_count' => 'required|integer|min:1|max:99',
            'pln_customer_id' => 'nullable|string|max:100',
            'national_decile' => 'required|integer|between:1,10',
            'provincial_decile' => 'required|integer|between:1,10',
            'regency_decile' => 'required|integer|between:1,10',
            'national_pbi' => 'required|in:Ya,Tidak',
            'local_pbi' => 'required|in:Ya,Tidak',
            'house_ownership' => 'required|string|max:100',
            'land_ownership' => 'required|in:Ya,Tidak',
            'other_assets' => 'required|in:Ya,Tidak',
            'floor_type' => 'required|string|max:100',
            'building_area' => 'required|numeric|min:0|max:99999',
            'wall_type' => 'required|string|max:150',
            'roof_material' => 'required|string|max:100',
            'roof_damage_level' => 'required|in:Rusak Berat,Rusak Sedang,Rusak Ringan',
            'foundation_condition' => 'required|in:Rusak Berat,Rusak Sedang,Rusak Ringan',
            'beam_column_condition' => 'required|in:Rusak Berat,Rusak Sedang,Rusak Ringan',
            'window_availability' => 'required|in:Ada,Tidak',
            'ventilation_availability' => 'required|in:Ada,Tidak',
            'mck_availability' => 'required|in:Ada,Tidak',
            'water_source' => 'required|string|max:255',
            'electricity_source' => 'required|string|max:100',
            'electricity_capacity' => 'required|string|max:100',
            'cooking_fuel' => 'required|string|max:100',
            'toilet_facility' => 'required|string|max:100',
            'toilet_type' => 'required|string|max:100',
            'sewage_disposal' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'consent' => 'accepted',
        ];
        foreach (self::PHOTO_FIELDS as $input => $column) {
            $rules[$input] = 'required|file|image|mimes:jpg,jpeg,png,webp|mimetypes:image/jpeg,image/png,image/webp|max:5120|dimensions:min_width=320,min_height=240,max_width=8000,max_height=8000';
        }

        $data = $request->validate($rules, [
            'family_card_number.unique' => 'Nomor Kartu Keluarga ini sudah terdaftar pada data RTLH.',
            'family_card_number.digits' => 'Nomor Kartu Keluarga harus terdiri dari 16 digit.',
            'national_id.digits' => 'NIK harus terdiri dari 16 digit.',
            '*.image' => 'File dokumentasi harus berupa gambar asli.',
            '*.mimes' => 'Dokumentasi hanya menerima file JPG, PNG, atau WEBP.',
            '*.mimetypes' => 'Tipe file dokumentasi tidak aman atau tidak didukung.',
            '*.max' => 'Ukuran setiap gambar maksimal 5 MB.',
            '*.dimensions' => 'Ukuran gambar harus minimal 320 × 240 piksel dan maksimal 8000 × 8000 piksel.',
        ]);
        unset($data['consent']);
        foreach (self::PHOTO_FIELDS as $input => $column) {
            if ($request->hasFile($input)) {
                $data[$column] = $request->file($input)->store('rlth-submissions', 'public');
            }
            unset($data[$input]);
        }

        $data['name'] = $data['head_of_family_name'];
        unset($data['head_of_family_name']);
        $submission = RlthRecord::create($data + [
            'submission_code' => 'RTLH-'.now()->format('Ymd').'-'.strtoupper(Str::random(6)),
            'submission_status' => 'pending',
            'submitted_at' => now(),
            'consented_at' => now(),
        ]);

        return redirect()->route('public.rlth.create')->with('success', 'Pendataan berhasil dikirim. Nomor pengajuan Anda: '.$submission->submission_code.'. Data akan diverifikasi oleh petugas.');
    }
}
