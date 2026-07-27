<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    private function rules(): array { return ['title'=>'required|max:255','description'=>'nullable','location'=>'nullable|max:255','start_date'=>'required|date','end_date'=>'nullable|date|after_or_equal:start_date','start_time'=>'nullable','end_time'=>'nullable','status'=>'required|in:draft,scheduled,ongoing,completed,cancelled']; }
    public function index() { return view('console.agendas',['agendas'=>Agenda::latest('start_date')->latest('start_time')->get()]); }
    public function store(Request $request) { Agenda::create($request->validate($this->rules())); return back()->with('success','Agenda ditambahkan.'); }
    public function update(Request $request, Agenda $agenda) { $agenda->update($request->validate($this->rules())); return back()->with('success','Agenda diperbarui.'); }
    public function destroy(Agenda $agenda) { $agenda->delete(); return back()->with('success','Agenda dihapus.'); }
}
