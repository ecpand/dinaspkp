<?php

namespace App\Http\Controllers;

use App\Models\MbbrArea;
use App\Models\MbbrProgram;
use App\Models\MbbrProgramType;
use App\Models\MbbrRecipient;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MbbrManagementController extends Controller
{
    public function dashboard() { return view('console.mbbr.dashboard', ['types'=>MbbrProgramType::withCount('programs')->get(), 'programList'=>MbbrProgram::with('type')->latest()->get(), 'programs'=>MbbrProgram::count(), 'recipients'=>MbbrRecipient::count(), 'areas'=>MbbrArea::count()]); }
    public function storeProgram(Request $request) { MbbrProgram::create($request->validate(['mbbr_program_type_id'=>'required|exists:mbbr_program_types,id','code'=>'required|max:100|unique:mbbr_programs','name'=>'required|max:255','fiscal_year'=>'required|integer|min:2020|max:2100','budget'=>'nullable|numeric|min:0','status'=>['required',Rule::in(['planning','active','completed','cancelled'])],'description'=>'nullable'])); return back()->with('success','Sub program MBBR ditambahkan.'); }
    public function programs() { return view('console.mbbr.programs',['types'=>MbbrProgramType::orderBy('name')->get(),'programs'=>MbbrProgram::with('type')->latest()->get()]); }
    public function updateProgram(Request $request, MbbrProgram $program) { $program->update($request->validate(['mbbr_program_type_id'=>'required|exists:mbbr_program_types,id','code'=>['required','max:100',Rule::unique('mbbr_programs')->ignore($program->id)],'name'=>'required|max:255','fiscal_year'=>'required|integer|min:2020|max:2100','budget'=>'nullable|numeric|min:0','status'=>['required',Rule::in(['planning','active','completed','cancelled'])],'description'=>'nullable'])); return back()->with('success','Sub program diperbarui.'); }
    public function destroyProgram(MbbrProgram $program) { $program->delete(); return back()->with('success','Sub program dihapus.'); }
    public function types() { return view('console.mbbr.types', ['types'=>MbbrProgramType::withCount('programs')->get()]); }
    public function storeType(Request $request) { MbbrProgramType::create($request->validate(['code'=>'required|max:100|unique:mbbr_program_types','name'=>'required|max:255','description'=>'nullable'])); return back()->with('success','Jenis MBBR ditambahkan.'); }
    public function updateType(Request $request, MbbrProgramType $type) { $type->update($request->validate(['code'=>['required','max:100',Rule::unique('mbbr_program_types')->ignore($type->id)],'name'=>'required|max:255','description'=>'nullable'])); return back()->with('success','Jenis MBBR diperbarui.'); }
    public function destroyType(MbbrProgramType $type) { if($type->programs()->exists()) return back()->withErrors(['type'=>'Jenis MBBR tidak dapat dihapus karena sudah digunakan oleh sub program.']); $type->delete(); return back()->with('success','Jenis MBBR dihapus.'); }
    public function importPage() { return view('console.mbbr.import'); }
    public function import(Request $request) { $request->validate(['file'=>'required|file|mimes:csv,txt|max:20480']); $path=$request->file('file')->store('imports','local'); $filePath=Storage::disk('local')->path($path); Artisan::call('mbbr:import-csv',['file'=>$filePath]); Storage::disk('local')->delete($path); return back()->with('success', trim(Artisan::output())); }
    public function areas(Request $request) {
        $areas = MbbrArea::with('regency')
            ->when($request->filled('cari'), fn ($query) => $query->where('name', 'like', '%'.$request->string('cari').'%'))
            ->when($request->filled('regency_id'), fn ($query) => $query->where('regency_id', $request->integer('regency_id')))
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('console.mbbr.areas', ['areas'=>$areas, 'regencies'=>Regency::orderBy('name')->get()]);
    }
    public function storeArea(Request $request) { $data=$request->validate(['name'=>'required|max:255','regency_id'=>'nullable|exists:regencies,id','color'=>['required','regex:/^#[0-9A-Fa-f]{6}$/'],'geojson'=>'required|json']); $data['geojson']=json_decode($data['geojson'],true); MbbrArea::create($data); return back()->with('success','GeoJSON wilayah ditambahkan.'); }
    public function updateArea(Request $request, MbbrArea $area) { $data=$request->validate(['name'=>'required|max:255','regency_id'=>'nullable|exists:regencies,id','color'=>['required','regex:/^#[0-9A-Fa-f]{6}$/'],'geojson'=>'required|json']); $data['geojson']=json_decode($data['geojson'],true); $area->update($data); return back()->with('success','GeoJSON wilayah diperbarui.'); }
    public function importAreas(Request $request) {
        $request->validate(['file'=>'required|file|extensions:json,geojson,js|max:20480','regency_id'=>'nullable|exists:regencies,id','color'=>['required','regex:/^#[0-9A-Fa-f]{6}$/']], ['file.extensions'=>'File harus berekstensi .json, .geojson, atau .js.']);
        try { $source=$this->decodeGeoSource(file_get_contents($request->file('file')->getRealPath())); } catch (\Throwable) { return back()->withErrors(['file'=>'File GeoJSON / JavaScript tidak valid.']); }
        $features = $source['type'] === 'FeatureCollection' ? ($source['features'] ?? []) : [$source];
        $baseNames = [];
        foreach ($features as $index => $feature) {
            $properties = $feature['properties'] ?? [];
            $baseName = (string) ($properties['name'] ?? $properties['Nama'] ?? $properties['Kawasan'] ?? $properties['WADMKK'] ?? 'Wilayah '.($index + 1));
            $baseNames[$baseName] = ($baseNames[$baseName] ?? 0) + 1;
        }

        $count = 0;
        foreach ($features as $index => $feature) {
            $geometry = $feature['geometry'] ?? $feature;
            if (!in_array($geometry['type'] ?? null, ['Polygon', 'MultiPolygon'], true)) continue;
            $props = $feature['properties'] ?? [];
            $baseName = (string) ($props['name'] ?? $props['Nama'] ?? $props['Kawasan'] ?? $props['WADMKK'] ?? 'Wilayah '.($index + 1));
            $subLabel = (string) ($props['Kode_RT_RW'] ?? $props['RT_RW'] ?? $props['Kelurahan'] ?? 'Bagian '.($index + 1));
            $subLabel = preg_replace('/^\s*[^-]+-\s*/', '', $subLabel);
            $name = $baseNames[$baseName] > 1 ? $baseName.' — '.$subLabel : $baseName;
            $data = ['geojson'=>$geometry, 'color'=>$request->input('color')];

            // Konversi data impor lama yang masih memakai nama umum menjadi bagian pertama.
            $legacy = $name !== $baseName ? MbbrArea::where('name', $baseName)->where('regency_id', $request->regency_id)->first() : null;
            if ($legacy) {
                $legacy->update(array_merge($data, ['name'=>$name]));
            } else {
                MbbrArea::updateOrCreate(['name'=>$name, 'regency_id'=>$request->regency_id], $data);
            }
            $count++;
        }
        return back()->with('success', "Impor GeoJSON selesai: {$count} wilayah diproses.");
    }
    public function villages(Request $request) { $villages=\App\Models\Village::with('regency')->withCount('recipients')->when($request->filled('regency_id'),fn($q)=>$q->where('regency_id',$request->integer('regency_id')))->when($request->filled('cari'),fn($q)=>$q->where('name','like','%'.$request->string('cari').'%'))->orderBy('name')->paginate(15)->withQueryString(); return view('console.mbbr.villages',['villages'=>$villages,'regencies'=>Regency::orderBy('name')->get()]); }
    public function storeVillage(Request $request) { \App\Models\Village::firstOrCreate($request->validate(['regency_id'=>'required|exists:regencies,id','name'=>'required|max:255'])); return back()->with('success','Desa disimpan.'); }
    public function updateVillage(Request $request, \App\Models\Village $village) { $village->update($request->validate(['regency_id'=>'required|exists:regencies,id','name'=>'required|max:255'])); return back()->with('success','Desa diperbarui.'); }
    public function destroyVillage(\App\Models\Village $village) { if($village->recipients()->exists()) return back()->withErrors(['village'=>'Desa tidak dapat dihapus karena sudah digunakan oleh data penerima.']); $village->delete(); return back()->with('success','Desa dihapus.'); }
    public function destroyArea(MbbrArea $area) { $area->delete(); return back()->with('success','Wilayah GeoJSON dihapus.'); }

    private function decodeGeoSource(string $content): array
    {
        $content = preg_replace('/^\xEF\xBB\xBF/', '', trim($content));
        try { return json_decode($content, true, 512, JSON_THROW_ON_ERROR); } catch (\Throwable) { }
        if (!preg_match('/(?:var|let|const)\s+[A-Za-z_$][\w$]*\s*=\s*(\{.*\}|\[.*\])\s*;?\s*$/s', $content, $matches)) throw new \InvalidArgumentException();
        return json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
    }
}
