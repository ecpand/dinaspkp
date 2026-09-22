<?php

namespace App\Http\Controllers;

use App\Models\RelatedInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RelatedInstitutionController extends Controller
{
    public function index()
    {
        return view('console.related-institutions.index', [
            'institutions' => RelatedInstitution::orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        RelatedInstitution::create($this->data($request));
        return back()->with('success', 'Instansi terkait berhasil ditambahkan.');
    }

    public function update(Request $request, RelatedInstitution $institution)
    {
        $institution->update($this->data($request, $institution));
        return back()->with('success', 'Instansi terkait berhasil diperbarui.');
    }

    public function destroy(RelatedInstitution $institution)
    {
        if ($institution->logo_path) Storage::disk('public')->delete($institution->logo_path);
        $institution->delete();
        return back()->with('success', 'Instansi terkait berhasil dihapus.');
    }

    private function data(Request $request, ?RelatedInstitution $institution = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'website_url' => ['required', 'url', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            if ($institution?->logo_path) Storage::disk('public')->delete($institution->logo_path);
            $data['logo_path'] = $request->file('logo')->store('related-institutions', 'public');
        }
        unset($data['logo']);
        return $data;
    }
}
