<?php

namespace App\Http\Controllers;

use App\Models\ProvincialLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProvincialLeaderController extends Controller
{
    public function index()
    {
        return view('console.leaders', ['leaders' => ProvincialLeader::orderBy('sort_order')->get()]);
    }

    public function store(Request $request)
    {
        ProvincialLeader::create($this->data($request));
        return back()->with('success', 'Pimpinan ditambahkan.');
    }

    public function update(Request $request, ProvincialLeader $leader)
    {
        $leader->update($this->data($request));
        return back()->with('success', 'Data pimpinan diperbarui.');
    }

    public function destroy(ProvincialLeader $leader)
    {
        $leader->delete();
        return back()->with('success', 'Pimpinan dihapus.');
    }

    private function data(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => ['required', Rule::in(['gubernur', 'wakil_gubernur', 'sekda'])],
            'period' => 'nullable|string|max:50',
            'vision' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'emblem_path' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        if ($request->hasFile('photo')) {
            $existingPath = $request->route('leader')?->photo_path;
            if ($existingPath && !str_starts_with($existingPath, 'assets/') && !str_starts_with($existingPath, 'storage/')) {
                Storage::disk('public')->delete($existingPath);
            }
            $data['photo_path'] = $request->file('photo')->store('provincial-leaders', 'public');
        }
        unset($data['photo']);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }
}
