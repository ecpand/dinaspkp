<?php

namespace App\Http\Controllers;

use App\Models\MbbrRecipient;
use App\Models\MbbrProgram;
use App\Models\MbbrProgramType;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MbbrRecipientController extends Controller
{
    public function index(Request $request)
    {
        $query = MbbrRecipient::with(['program.type', 'regency', 'village']);
        $query->when($request->filled('cari'), fn ($q) => $q->where('name', 'like', '%'.$request->string('cari').'%'));
        $query->when($request->filled('program_type_id'), fn ($q) => $q->whereHas('program', fn ($program) => $program->where('mbbr_program_type_id', $request->integer('program_type_id'))));
        $query->when($request->filled('fiscal_year'), fn ($q) => $q->whereHas('program', fn ($program) => $program->where('fiscal_year', $request->integer('fiscal_year'))));
        $query->when($request->filled('mbbr_program_id'), fn ($q) => $q->where('mbbr_program_id', $request->integer('mbbr_program_id')));
        $query->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')));
        $query->when($request->filled('village_id'), fn ($q) => $q->where('village_id', $request->integer('village_id')));
        $recipients = (clone $query)->latest()->paginate(10)->withQueryString();
        $programs=MbbrProgram::with('type')->orderByDesc('fiscal_year')->orderBy('name')->get(); return view('console.recipients', ['recipients'=>$recipients,'programs'=>$programs,'years'=>$programs->pluck('fiscal_year')->unique()->sortDesc()->values(),'types'=>MbbrProgramType::orderBy('name')->get(),'regencies'=>Regency::orderBy('name')->get(),'villages'=>Village::orderBy('name')->get(),'total'=>MbbrRecipient::count(),'completed'=>MbbrRecipient::where('status','completed')->count(),'process'=>MbbrRecipient::where('status','process')->count(),'waiting'=>MbbrRecipient::where('status','waiting')->count()]);
    }

    public function updatePhotos(Request $request, MbbrRecipient $recipient)
    {
        $data = $request->validate(['photo_initial' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', 'photo_progress' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120']);
        foreach (['photo_initial' => 'photo_initial_path', 'photo_progress' => 'photo_progress_path'] as $input => $column) {
            if ($request->hasFile($input)) {
                if ($recipient->$column) Storage::disk('public')->delete($recipient->$column);
                $data[$column] = $request->file($input)->store('mbbr-recipients', 'public');
            }
            unset($data[$input]);
        }
        $recipient->update($data);
        return back()->with('success', 'Dokumentasi foto penerima diperbarui.');
    }
    private function rules(): array { return ['mbbr_program_id'=>'required|exists:mbbr_programs,id','regency_id'=>'nullable|exists:regencies,id','village_id'=>'nullable|exists:villages,id','new_village_name'=>'nullable|string|max:255','name'=>'required|max:255','address'=>'nullable','companion_name'=>'nullable|max:255','condition'=>'nullable|max:255','provider_name'=>'nullable|max:255','decile'=>'nullable|integer|min:1|max:10','material_cost'=>'nullable|numeric|min:0','labor_cost'=>'nullable|numeric|min:0','material_progress'=>'nullable|numeric|min:0|max:100','labor_progress'=>'nullable|numeric|min:0|max:100','progress'=>'nullable|numeric|min:0|max:100','latitude'=>'nullable|numeric','longitude'=>'nullable|numeric','status'=>'required|in:waiting,process,completed','photo_initial'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','photo_progress'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120']; }
    public function store(Request $request) { $recipient=MbbrRecipient::create($this->data($request)); return back()->with('success', 'Penerima '.$recipient->name.' ditambahkan.'); }
    public function update(Request $request, MbbrRecipient $recipient) { $recipient->update($this->data($request,$recipient)); return back()->with('success','Data penerima diperbarui.'); }
    public function destroy(MbbrRecipient $recipient) { foreach(['photo_initial_path','photo_progress_path'] as $field) if($recipient->$field) Storage::disk('public')->delete($recipient->$field); $recipient->delete(); return back()->with('success','Data penerima dihapus.'); }
    private function data(Request $request, ?MbbrRecipient $recipient=null): array { foreach(['material_cost','labor_cost'] as $field) if(is_string($request->input($field)))$request->merge([$field=>preg_replace('/[^0-9]/','',$request->input($field))]); $data=$request->validate($this->rules()); if(filled($data['new_village_name']??null)){if(blank($data['regency_id']??null))abort(422,'Pilih kabupaten terlebih dahulu untuk menambahkan desa baru.');$data['village_id']=Village::firstOrCreate(['regency_id'=>$data['regency_id'],'name'=>trim($data['new_village_name'])])->id;}unset($data['new_village_name']);foreach(['photo_initial'=>'photo_initial_path','photo_progress'=>'photo_progress_path'] as $input=>$column){if($request->hasFile($input)){if($recipient?->$column)Storage::disk('public')->delete($recipient->$column);$data[$column]=$request->file($input)->store('mbbr-recipients','public');}unset($data[$input]);} $data['material_remaining']=max(0,(float)($data['material_cost']??0)*(1-(float)($data['material_progress']??0)/100));$data['labor_remaining']=max(0,(float)($data['labor_cost']??0)*(1-(float)($data['labor_progress']??0)/100));return $data; }
    public function export(Request $request) { $items=MbbrRecipient::with(['program.type','regency','village'])->get(); return response()->streamDownload(function()use($items){$out=fopen('php://output','w');fputcsv($out,['Nama','Desa','Kabupaten','Program','Sub Program','Progress','Status']);foreach($items as $r)fputcsv($out,[$r->name,$r->village?->name,$r->regency?->name,$r->program?->type?->name,$r->program?->name,$r->progress,$r->status]);fclose($out);},'data-penerima-mbbr.csv',['Content-Type'=>'text/csv']); }
}
