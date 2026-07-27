<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        return view('console.documents', ['documents' => Document::latest('published_date')->latest()->paginate(15)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['peraturan', 'informasi', 'unduhan'])],
            'description' => ['nullable', 'string'],
            'published_date' => ['nullable', 'date'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar', 'max:20480'],
        ]);
        $data['file_path'] = $request->file('file')->store('documents', 'public');
        unset($data['file']);
        Document::create($data);

        return back()->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, Document $document)
    {
        $data=$request->validate(['title'=>['required','string','max:255'],'category'=>['required',Rule::in(['peraturan','informasi','unduhan'])],'description'=>['nullable','string'],'published_date'=>['nullable','date'],'file'=>['nullable','file','mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar','max:20480']]);
        if($request->hasFile('file')) { if(!str_starts_with($document->file_path,'assets/')) Storage::disk('public')->delete($document->file_path); $data['file_path']=$request->file('file')->store('documents','public'); }
        unset($data['file']); $document->update($data);
        return back()->with('success','Dokumen diperbarui.');
    }

    public function destroy(Document $document)
    {
        if(!str_starts_with($document->file_path,'assets/')) Storage::disk('public')->delete($document->file_path); $document->delete();
        return back()->with('success', 'Dokumen dihapus.');
    }
}
