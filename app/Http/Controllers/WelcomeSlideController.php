<?php

namespace App\Http\Controllers;

use App\Models\WelcomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WelcomeSlideController extends Controller
{
    public function index()
    {
        return view('console.welcome-slides', ['slides' => WelcomeSlide::orderBy('sort_order')->get()]);
    }

    public function store(Request $request)
    {
        WelcomeSlide::create($this->data($request));
        return back()->with('success', 'Welcome slide ditambahkan.');
    }

    public function update(Request $request, WelcomeSlide $slide)
    {
        $slide->update($this->data($request, $slide));
        return back()->with('success', 'Welcome slide diperbarui.');
    }

    public function destroy(WelcomeSlide $slide)
    {
        if ($slide->image_path && !str_starts_with($slide->image_path, 'assets/') && !str_starts_with($slide->image_path, 'storage/')) {
            Storage::disk('public')->delete($slide->image_path);
        }
        $slide->delete();
        return back()->with('success', 'Welcome slide dihapus.');
    }

    private function data(Request $request, ?WelcomeSlide $slide = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => [$slide ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'button_label' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slide?->image_path && !str_starts_with($slide->image_path, 'assets/') && !str_starts_with($slide->image_path, 'storage/')) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $data['image_path'] = $request->file('image')->store('welcome-slides', 'public');
        }
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
