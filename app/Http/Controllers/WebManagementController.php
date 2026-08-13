<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalUnit;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class WebManagementController extends Controller
{
    public function index() { return view('console.web.index'); }
    public function settings()
    {
        return view('console.web.settings', ['setting' => WebsiteSetting::first()]);
    }

    public function updateSettings(Request $request)
    {
        $setting = WebsiteSetting::first();
        $data = $request->validate([
            'agency_name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:2000',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|file|mimes:ico,png|max:1024',
        ]);

        $data['social_links'] = array_filter([
            'facebook' => $data['facebook'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'youtube' => $data['youtube'] ?? null,
        ]);
        unset($data['facebook'], $data['instagram'], $data['youtube']);

        foreach (['logo' => 'logo_path', 'favicon' => 'favicon_path'] as $input => $column) {
            if (!$request->hasFile($input)) {
                continue;
            }
            if ($setting?->{$column}) {
                Storage::disk('public')->delete($setting->{$column});
            }
            $data[$column] = $request->file($input)->store('website', 'public');
        }
        unset($data['logo'], $data['favicon']);

        WebsiteSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Pengaturan website berhasil diperbarui.');
    }
    public function page(string $section)
    {
        abort_unless(in_array($section, ['profil-dinas', 'visi-misi', 'tugas-fungsi', 'struktur-organisasi'], true), 404);
        $units = $section === 'struktur-organisasi' ? OrganizationalUnit::orderBy('parent_key')->orderBy('sort_order')->paginate(10)->withQueryString() : collect();
        return view('console.web.page', ['section' => $section, 'setting' => WebsiteSetting::first(), 'units' => $units, 'parentUnits' => OrganizationalUnit::orderBy('name')->get()]);
    }
    public function save(Request $request, string $section)
    {
        abort_unless(in_array($section, ['profil-dinas', 'visi-misi', 'tugas-fungsi'], true), 404);
        $fields = match ($section) {
            'profil-dinas' => ['agency_name'=>'required|max:255','short_name'=>'nullable|max:255','profile_tagline'=>'nullable|max:255','about'=>'nullable','history'=>'nullable','profile_direction'=>'nullable','milestone_title'=>'nullable|array','milestone_title.*'=>'nullable|max:255','milestone_description'=>'nullable|array','milestone_description.*'=>'nullable','service_scope'=>'nullable|array','service_scope.*'=>'nullable|max:255'],
            'visi-misi' => ['vision'=>'nullable','mission'=>'nullable'],
            default => ['duties'=>'nullable','duty_function_title'=>'nullable|array','duty_function_title.*'=>'nullable|max:255','duty_function_items'=>'nullable|array','duty_function_items.*'=>'nullable'],
        };
        $data = $request->validate($fields);
        if ($section === 'profil-dinas') {
            $data['profile_milestones'] = collect($data['milestone_title'] ?? [])->map(function ($title, $index) use ($data) {
                return ['title' => trim((string) $title), 'description' => trim((string) ($data['milestone_description'][$index] ?? ''))];
            })->filter(fn ($item) => $item['title'] !== '' || $item['description'] !== '')->values()->all();
            $data['service_scopes'] = collect($data['service_scope'] ?? [])->map(fn ($item) => trim((string) $item))->filter()->values()->all();
            unset($data['milestone_title'], $data['milestone_description'], $data['service_scope']);
        }
        if ($section === 'tugas-fungsi') {
            $data['duty_functions'] = collect($data['duty_function_title'] ?? [])->map(function ($title, $index) use ($data) {
                $items = preg_split('/\r\n|\r|\n/', (string) ($data['duty_function_items'][$index] ?? ''));
                return ['title' => trim((string) $title), 'items' => collect($items)->map(fn ($item) => trim($item))->filter()->values()->all()];
            })->filter(fn ($function) => $function['title'] !== '' || count($function['items']) > 0)->values()->all();
            unset($data['duty_function_title'], $data['duty_function_items']);
        }
        WebsiteSetting::updateOrCreate(['id'=>1], $data);
        return back()->with('success', 'Konten website berhasil diperbarui.');
    }
    public function storeUnit(Request $request)
    {
        $data=$request->validate(['name'=>'required|max:255','unit_key'=>'required|max:100|unique:organizational_units','parent_key'=>'nullable|max:100','sort_order'=>'nullable|integer','is_active'=>'nullable|boolean']); $data['is_active']=$request->boolean('is_active'); OrganizationalUnit::create($data);
        return back()->with('success', 'Unit struktur ditambahkan.');
    }
    public function updateUnit(Request $request, OrganizationalUnit $unit) { $data=$request->validate(['name'=>'required|max:255','unit_key'=>['required','max:100',Rule::unique('organizational_units')->ignore($unit->id)],'parent_key'=>'nullable|max:100','sort_order'=>'nullable|integer','is_active'=>'nullable|boolean']); $data['is_active']=$request->boolean('is_active'); $unit->update($data); return back()->with('success','Unit struktur diperbarui.'); }
    public function destroyUnit(OrganizationalUnit $unit) { $unit->delete(); return back()->with('success', 'Unit struktur dihapus.'); }
}
