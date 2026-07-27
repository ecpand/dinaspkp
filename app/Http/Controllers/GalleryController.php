<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    public function index()
    {
        return view('console.galleries', ['galleries' => Gallery::latest()->get()]);
    }

    public function store(Request $request)
    {
        Gallery::create($this->data($request, true));

        return back()->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $gallery->update($this->data($request));
        return back()->with('success', 'Item galeri diperbarui.');
    }

    private function data(Request $request, bool $isNew = false): array
    {
        $data = $request->validate(['title'=>['required','string','max:255'],'description'=>['nullable','string'],'category'=>['required',Rule::in(['kegiatan','informasi','video'])],'image'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],'video_url'=>['nullable','url','max:255'],'is_active'=>['nullable','boolean']]);
        if ($isNew && $data['category'] !== 'video') $request->validate(['image'=>['required','image','mimes:jpg,jpeg,png,webp','max:5120']]);
        if ($data['category'] === 'video') $request->validate(['video_url'=>['required','url','max:255']]);
        if ($request->hasFile('image')) $data['image_path']=$request->file('image')->store('galleries','public');
        $data['is_active']=$request->boolean('is_active'); unset($data['image']); return $data;
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Item galeri dihapus.');
    }
}
