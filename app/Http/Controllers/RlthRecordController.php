<?php

namespace App\Http\Controllers;

use App\Models\RlthRecord;
use App\Services\RlthImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RlthRecordController extends Controller
{
    private const PHOTO_FIELDS = [
        'photo_front' => 'photo_front_path', 'photo_left' => 'photo_left_path',
        'photo_right' => 'photo_right_path', 'photo_back' => 'photo_back_path',
        'photo_roof' => 'photo_roof_path', 'photo_window' => 'photo_window_path',
        'photo_mck' => 'photo_mck_path',
    ];

    public function index(Request $request)
    {
        $query = RlthRecord::query();
        $query->when($request->filled('cari'), fn ($q) => $q->where(fn ($search) => $search->where('name', 'like', '%'.$request->string('cari').'%')->orWhere('national_id', 'like', '%'.$request->string('cari').'%')->orWhere('village_name', 'like', '%'.$request->string('cari').'%')));
        $query->when($request->filled('tahun'), fn ($q) => $q->where('survey_year', $request->integer('tahun')));
        $query->when($request->filled('kabupaten'), fn ($q) => $q->where('regency_name', $request->string('kabupaten')));
        $query->when($request->filled('kerusakan'), fn ($q) => $q->where('roof_damage_level', $request->string('kerusakan')));
        $query->when($request->filled('status'), fn ($q) => $q->where('submission_status', $request->string('status')));
        $records = $query->latest()->paginate(10)->withQueryString();
        $base = RlthRecord::query();
        return view('console.rlth-records', [
            'records' => $records,
            'total' => $base->count(),
            'mapped' => (clone $base)->whereNotNull('latitude')->whereNotNull('longitude')->count(),
            'years' => (clone $base)->whereNotNull('survey_year')->distinct()->orderByDesc('survey_year')->pluck('survey_year'),
            'regencies' => (clone $base)->whereNotNull('regency_name')->distinct()->orderBy('regency_name')->pluck('regency_name'),
            'damages' => (clone $base)->whereNotNull('roof_damage_level')->distinct()->orderBy('roof_damage_level')->pluck('roof_damage_level'),
            'statusCounts' => (clone $base)->selectRaw('submission_status, count(*) as total')->groupBy('submission_status')->pluck('total', 'submission_status'),
        ]);
    }

    public function store(Request $request) { RlthRecord::create($this->data($request)); return back()->with('success', 'Data RLTH berhasil ditambahkan.'); }
    public function update(Request $request, RlthRecord $record) { $record->update($this->data($request, $record)); return back()->with('success', 'Data RLTH berhasil diperbarui.'); }
    public function destroy(RlthRecord $record) { foreach (self::PHOTO_FIELDS as $column) if ($record->{$column}) Storage::disk('public')->delete($record->{$column}); $record->delete(); return back()->with('success', 'Data RLTH berhasil dihapus.'); }
    public function updateStatus(Request $request, RlthRecord $record)
    {
        $data = $request->validate(['submission_status' => 'required|in:pending,verified,rejected']);
        $record->update($data);
        $label = ['pending' => 'menunggu verifikasi', 'verified' => 'terverifikasi', 'rejected' => 'ditolak'][$data['submission_status']];
        return back()->with('success', "Status pengajuan {$record->name} diubah menjadi {$label}.");
    }
    public function import(Request $request, RlthImportService $importer)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx,csv,txt|max:20480']);
        try {
            $result = $importer->import($request->file('file')->getRealPath());
            return back()->with('success', "Import RTLH selesai: {$result['created']} data baru, {$result['updated']} data diperbarui, {$result['skipped']} baris dilewati.");
        } catch (\Throwable $exception) {
            return back()->withErrors(['file' => 'Import gagal: '.$exception->getMessage()]);
        }
    }

    public function template()
    {
        $headers = ['Tahun','Nama','Nomor KTP','Nomor KK','No HP','Alamat','Kabupaten/Kota','Kelurahan/Desa','Latitude','Longitude','Pekerjaan','Penghasilan','Status Kepemilikan Rumah','Status Kepemilikan Tanah','Kepemilikan Aset tempat lain','Kondisi Pondasi Rumah','Kondisi Balok dan kolom','Ketersediaan Jendela','Ketersediaan Ventilasi','Ketersediaan MCK','Ketersediaan Air Bersih','Jenis Dinding','Material Atap','Tingkat kerusakan atap','Luas Bangunan'];
        return response(implode(',', $headers)."\n", 200, ['Content-Type' => 'text/csv; charset=UTF-8', 'Content-Disposition' => 'attachment; filename="template-pendataan-rlth.csv"']);
    }

    private function data(Request $request, ?RlthRecord $record = null): array
    {
        $rules = [
            'survey_year'=>'nullable|integer|min:2000|max:2100','name'=>'required|string|max:255','national_id'=>'nullable|string|max:32','family_card_number'=>['nullable','string','max:32', Rule::unique('rlth_records', 'family_card_number')->ignore($record?->id)],'phone'=>'nullable|string|max:40','address'=>'nullable|string|max:2000','province_name'=>'nullable|string|max:255','regency_name'=>'nullable|string|max:255','district_name'=>'nullable|string|max:255','village_name'=>'nullable|string|max:255','latitude'=>'nullable|numeric|between:-90,90','longitude'=>'nullable|numeric|between:-180,180','occupation'=>'nullable|string|max:255','income_range'=>'nullable|string|max:255','family_member_count'=>'nullable|integer|min:1|max:99','pln_customer_id'=>'nullable|string|max:100','national_decile'=>'nullable|integer|between:1,10','provincial_decile'=>'nullable|integer|between:1,10','regency_decile'=>'nullable|integer|between:1,10','national_pbi'=>'nullable|in:Ya,Tidak','local_pbi'=>'nullable|in:Ya,Tidak','house_ownership'=>'nullable|string|max:255','floor_type'=>'nullable|string|max:255','land_ownership'=>'nullable|string|max:255','other_assets'=>'nullable|string|max:255','foundation_condition'=>'nullable|string|max:255','beam_column_condition'=>'nullable|string|max:255','window_availability'=>'nullable|string|max:100','ventilation_availability'=>'nullable|string|max:100','mck_availability'=>'nullable|string|max:100','water_source'=>'nullable|string|max:255','electricity_source'=>'nullable|string|max:255','electricity_capacity'=>'nullable|string|max:100','cooking_fuel'=>'nullable|string|max:100','toilet_facility'=>'nullable|string|max:100','toilet_type'=>'nullable|string|max:100','sewage_disposal'=>'nullable|string|max:255','wall_type'=>'nullable|string|max:255','roof_material'=>'nullable|string|max:255','roof_damage_level'=>'nullable|string|max:255','building_area'=>'nullable|numeric|min:0',
        ];
        foreach (self::PHOTO_FIELDS as $input => $column) $rules[$input] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120';
        $data = $request->validate($rules);
        foreach (self::PHOTO_FIELDS as $input => $column) {
            if ($request->hasFile($input)) {
                if ($record?->{$column}) Storage::disk('public')->delete($record->{$column});
                $data[$column] = $request->file($input)->store('rlth', 'public');
            }
            unset($data[$input]);
        }
        return $data;
    }
}
