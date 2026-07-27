<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\MbbrProgram;
use App\Models\MbbrProgramType;
use App\Models\MbbrRecipient;
use App\Models\ServiceReview;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ConsoleController extends Controller
{
    public function login() { return view('console.login'); }
    public function auth(Request $request) { $data=$request->validate(['username'=>'required','password'=>'required']); $user=User::where('username',$data['username'])->where('is_active',true)->first(); if(!$user || !Hash::check($data['password'],$user->password)) return back()->withErrors(['username'=>'Username atau kata sandi tidak valid.'])->onlyInput('username'); $request->session()->regenerate(); $request->session()->put('console_user',$user->id); return redirect('/console'); }
    public function logout(Request $request) { $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect('/console/login'); }
    public function dashboard()
    {
        $recipientByStatus = MbbrRecipient::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('console.dashboard', [
            'users' => User::count(),
            'programs' => MbbrProgram::count(),
            'agendas' => Agenda::count(),
            'recipients' => MbbrRecipient::count(),
            'recipientByStatus' => $recipientByStatus,
            'programTypes' => MbbrProgramType::withCount('programs')->orderBy('name')->get(),
            'upcomingAgendas' => Agenda::whereIn('status', ['scheduled', 'ongoing'])->orderBy('start_date')->orderBy('start_time')->limit(5)->get(),
            'latestReviews' => ServiceReview::latest()->limit(4)->get(),
        ]);
    }
    public function users(Request $request) {
        $users = User::query()
            ->when($request->filled('cari'), fn ($query) => $query->where(function ($items) use ($request) { $items->where('name', 'like', '%'.$request->input('cari').'%')->orWhere('username', 'like', '%'.$request->input('cari').'%')->orWhere('email', 'like', '%'.$request->input('cari').'%'); }))
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->input('role')))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->input('status') === 'active'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('console.users', compact('users'));
    }
    public function module(string $module) { return view('console.module',['module'=>$module,'setting'=>WebsiteSetting::first(),'types'=>MbbrProgramType::orderBy('name')->get(),'items'=>match($module){'users'=>User::latest()->get(),'program-mbbr'=>MbbrProgram::with('type')->latest()->get(),'agenda'=>Agenda::latest('start_date')->get(),default=>collect()}]); }
    public function store(Request $request,string $module) {
        if($module==='kelola-web'){ $this->saveSetting($request); return back()->with('success','Informasi website diperbarui.'); }
        if($module==='users'){ $data=$request->validate(['name'=>'required|max:255','username'=>'required|max:100|unique:users','email'=>'nullable|email|unique:users','password'=>'required|min:8','role'=>['required',Rule::in(['admin','editor'])]]); $data['password']=Hash::make($data['password']); User::create($data); }
        if($module==='program-mbbr'){ MbbrProgram::create($request->validate(['mbbr_program_type_id'=>'nullable|exists:mbbr_program_types,id','code'=>'required|max:100|unique:mbbr_programs','name'=>'required|max:255','fiscal_year'=>'required|integer|min:2020|max:2100','budget'=>'nullable|numeric|min:0','status'=>['required',Rule::in(['planning','active','completed','cancelled'])],'description'=>'nullable'])); }
        if($module==='agenda'){ Agenda::create($request->validate(['title'=>'required|max:255','description'=>'nullable','location'=>'nullable|max:255','start_date'=>'required|date','end_date'=>'nullable|date|after_or_equal:start_date','start_time'=>'nullable','end_time'=>'nullable','status'=>['required',Rule::in(['draft','scheduled','ongoing','completed','cancelled'])]])); }
        return back()->with('success','Data berhasil ditambahkan.');
    }
    public function update(Request $request,string $module,int $id) {
        if($module==='kelola-web'){ $this->saveSetting($request); return back()->with('success','Informasi website diperbarui.'); }
        if($module==='users'){ $item=User::findOrFail($id); $data=$request->validate(['name'=>'required|max:255','username'=>['required','max:100',Rule::unique('users')->ignore($id)],'email'=>['nullable','email',Rule::unique('users')->ignore($id)],'role'=>['required',Rule::in(['admin','editor'])],'is_active'=>'nullable|boolean','password'=>'nullable|min:8']); $data['is_active']=$request->boolean('is_active'); if(blank($data['password'])) unset($data['password']); else $data['password']=Hash::make($data['password']); $item->update($data); }
        if($module==='program-mbbr'){ $item=MbbrProgram::findOrFail($id); $item->update($request->validate(['mbbr_program_type_id'=>'nullable|exists:mbbr_program_types,id','code'=>['required','max:100',Rule::unique('mbbr_programs')->ignore($id)],'name'=>'required|max:255','fiscal_year'=>'required|integer|min:2020|max:2100','budget'=>'nullable|numeric|min:0','status'=>['required',Rule::in(['planning','active','completed','cancelled'])],'description'=>'nullable'])); }
        if($module==='agenda'){ $item=Agenda::findOrFail($id); $item->update($request->validate(['title'=>'required|max:255','description'=>'nullable','location'=>'nullable|max:255','start_date'=>'required|date','end_date'=>'nullable|date|after_or_equal:start_date','start_time'=>'nullable','end_time'=>'nullable','status'=>['required',Rule::in(['draft','scheduled','ongoing','completed','cancelled'])]])); }
        return back()->with('success','Data berhasil diperbarui.');
    }
    public function destroy(string $module,int $id) { if($module==='users') User::findOrFail($id)->delete(); if($module==='program-mbbr') MbbrProgram::findOrFail($id)->delete(); if($module==='agenda') Agenda::findOrFail($id)->delete(); return back()->with('success','Data berhasil dihapus.'); }
    private function saveSetting(Request $request): void { $data=$request->validate(['agency_name'=>'required|max:255','short_name'=>'nullable|max:255','about'=>'nullable','vision'=>'nullable','mission'=>'nullable','duties'=>'nullable','address'=>'nullable','phone'=>'nullable|max:50','email'=>'nullable|email','website'=>'nullable|max:255','facebook'=>'nullable|url','instagram'=>'nullable|url','youtube'=>'nullable|url']); $data['social_links']=array_filter(['facebook'=>$data['facebook']??null,'instagram'=>$data['instagram']??null,'youtube'=>$data['youtube']??null]); unset($data['facebook'],$data['instagram'],$data['youtube']); WebsiteSetting::updateOrCreate(['id'=>1],$data); }
}
