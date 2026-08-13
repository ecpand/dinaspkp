<?php

namespace App\Http\Controllers;

use App\Models\PkpService;
use Illuminate\Http\Request;

class PkpServiceController extends Controller
{
    public function index()
    {
        return view('console.pkp-services', [
            'services' => PkpService::orderBy('sort_order')->latest('id')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        PkpService::create($this->data($request));

        return back()->with('success', 'Layanan PKP berhasil ditambahkan.');
    }

    public function update(Request $request, PkpService $service)
    {
        $service->update($this->data($request));

        return back()->with('success', 'Layanan PKP berhasil diperbarui.');
    }

    public function destroy(PkpService $service)
    {
        $service->delete();

        return back()->with('success', 'Layanan PKP berhasil dihapus.');
    }

    private function data(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'url' => ['required', 'url', 'max:2048'],
            'icon' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['icon'] = $data['icon'] ?: 'fa-file-lines';

        return $data;
    }
}
