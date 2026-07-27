<?php

namespace App\Http\Controllers;

use App\Models\StructuralOfficial;
use Illuminate\Http\Request;

class StructuralOfficialController extends Controller
{
    private function rules(): array
    {
        return ['name'=>'required|max:255','nip'=>'nullable|max:30','position'=>'required|max:255','unit'=>'nullable|max:255','echelon'=>'nullable|max:100','education'=>'nullable|max:255','rank'=>'nullable|max:255','place_of_birth'=>'nullable|max:255','date_of_birth'=>'nullable|date','position_started_at'=>'nullable|date','appointment_number'=>'nullable|max:255','photo'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','bio'=>'nullable','education_history'=>'nullable','career_history'=>'nullable','sort_order'=>'nullable|integer'];
    }
    public function index(Request $request){ return view('console.officials', ['officials'=>StructuralOfficial::orderBy('sort_order')->orderBy('name')->paginate(10)->withQueryString()]); }
    public function store(Request $request){ $data=$this->data($request); StructuralOfficial::create($data); return back()->with('success','Data pejabat ditambahkan.'); }
    public function update(Request $request, StructuralOfficial $official){ $data=$this->data($request); $official->update($data); return back()->with('success','Data pejabat diperbarui.'); }
    public function destroy(StructuralOfficial $official){ $official->delete(); return back()->with('success','Data pejabat dihapus.'); }
    private function data(Request $request): array { $data=$request->validate($this->rules()+['is_active'=>'nullable|boolean']); $data['is_active']=$request->boolean('is_active'); if($request->hasFile('photo')) $data['photo_path']='storage/'.$request->file('photo')->store('officials','public'); unset($data['photo']); return $data; }
}
