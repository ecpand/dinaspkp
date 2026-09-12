<?php
namespace App\Http\Controllers;

use App\Models\{Agenda,Document,Gallery,MbbrArea,MbbrProgram,MbbrRecipient,MbbrProgramType,PkpService,Post,ProposalData,ProvincialLeader,Regency,RlthRecord,ServiceReview,StructuralOfficial,VisitorSession,WebsiteSetting,WelcomeSlide,Village};
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function page(Request $request, string $page = 'home')
    {
        if ($page === 'home') $this->recordVisit($request);
        $reviews = ServiceReview::selectRaw('rating, count(*) as total')->groupBy('rating')->pluck('total', 'rating');
        $total = $reviews->sum();
        $data = ['page'=>$page,'setting'=>WebsiteSetting::first(),'leaders'=>ProvincialLeader::where('is_active',true)->orderBy('sort_order')->get(),'welcomeSlides'=>WelcomeSlide::where('is_active',true)->orderBy('sort_order')->get(),'headOfficial'=>StructuralOfficial::where('is_active',true)->where('position','like','%Kepala Dinas%')->orderBy('sort_order')->first() ?? StructuralOfficial::where('is_active',true)->orderBy('sort_order')->first(),'agendas'=>Agenda::whereIn('status',['scheduled','ongoing'])->orderBy('start_date')->limit(4)->get(),'programs'=>MbbrProgram::with('type')->latest()->limit(6)->get(),'programCount'=>MbbrProgram::count(),'recipientCount'=>MbbrRecipient::count(),'posts'=>Post::where('status','published')->whereNotNull('published_at')->latest('published_at')->limit(4)->get(),'officials'=>StructuralOfficial::where('is_active',true)->orderBy('sort_order')->get(),'documents'=>Document::latest()->get(),'galleries'=>Gallery::where('is_active',true)->latest()->limit(6)->get(),'regencies'=>Regency::orderBy('name')->get(),'reviews'=>$reviews,'reviewTotal'=>$total,'reviewAverage'=>$total?round(ServiceReview::avg('rating'),1):0,'visitorToday'=>VisitorSession::whereDate('visit_date',today())->count(),'visitorMonth'=>VisitorSession::whereBetween('visit_date',[today()->startOfMonth(),today()->endOfMonth()])->count(),'visitorTotal'=>VisitorSession::count()];
        $data['agendas'] = Agenda::whereIn('status', ['scheduled', 'ongoing'])->orderBy('start_date')->limit(5)->get();
        if ($page === 'profil-dinas') return view('frontend.pages.profile.dinas', $data + ['title' => 'Profil Dinas']);
        if ($page === 'visi-misi') return view('frontend.pages.profile.vision-mission', $data + ['title' => 'Visi Misi']);
        if ($page === 'tugas-pokok-fungsi') return view('frontend.pages.profile.duties', $data + ['title' => 'Tugas Pokok dan Fungsi']);
        if ($page === 'struktur-organisasi') return view('frontend.pages.profile.structure', $data + ['title' => 'Struktur Organisasi']);
        if ($page === 'profil-pejabat') {
            $officialQuery = StructuralOfficial::where('is_active', true)->orderBy('sort_order');
            $officialQuery->when($request->filled('jabatan'), fn ($query) => $query->where('position', $request->string('jabatan')));
            $officialQuery->when($request->filled('eselon'), fn ($query) => $query->where('echelon', $request->string('eselon')));
            $officialQuery->when($request->filled('unit'), fn ($query) => $query->where('unit', $request->string('unit')));
            $allOfficials = StructuralOfficial::where('is_active', true)->orderBy('sort_order')->get();
            return view('frontend.pages.profile.officials', $data + [
                'title' => 'Pejabat Struktural',
                'officials' => $officialQuery->get(),
                'positionOptions' => $allOfficials->pluck('position')->filter()->unique()->values(),
                'echelonOptions' => $allOfficials->pluck('echelon')->filter()->unique()->sort()->values(),
                'unitOptions' => $allOfficials->pluck('unit')->filter()->unique()->sort()->values(),
            ]);
        }
        if ($page === 'agenda-kegiatan') {
            $allAgendas = Agenda::orderByDesc('start_date')->orderByDesc('start_time')->get();
            return view('frontend.pages.activities.agenda', $data + [
                'title' => 'Agenda Kegiatan',
                'allAgendas' => $allAgendas,
                'agendaTotal' => $allAgendas->count(),
                'agendaOngoing' => $allAgendas->where('status', 'ongoing')->count(),
                'agendaScheduled' => $allAgendas->where('status', 'scheduled')->count(),
                'agendaUpcoming' => $allAgendas->filter(fn ($agenda) => $agenda->start_date && $agenda->start_date->between(today(), today()->addDays(7)))->count(),
            ]);
        }
        if ($page === 'program-kegiatan') {
            $selectedType = $request->integer('jenis');
            $programQuery = MbbrProgram::with(['type', 'recipients.regency', 'recipients.village'])->withCount([
                'recipients',
                'recipients as recipients_completed_count' => fn ($query) => $query->where('status', 'completed'),
                'recipients as recipients_process_count' => fn ($query) => $query->where('status', 'process'),
                'recipients as recipients_waiting_count' => fn ($query) => $query->where('status', 'waiting'),
            ])->latest();
            $programQuery->when($request->filled('tahun'), fn ($query) => $query->where('fiscal_year', $request->integer('tahun')));
            $programQuery->when($selectedType, fn ($query) => $query->where('mbbr_program_type_id', $selectedType));
            $programQuery->when($request->filled('status'), fn ($query) => $query->whereHas('recipients', fn ($recipients) => $recipients->where('status', $request->string('status'))));
            $programQuery->when($request->filled('cari'), fn ($query) => $query->where(fn ($search) => $search->where('name', 'like', '%'.$request->string('cari').'%')->orWhere('code', 'like', '%'.$request->string('cari').'%')->orWhereHas('recipients', fn ($recipients) => $recipients->where('name', 'like', '%'.$request->string('cari').'%')->orWhereHas('village', fn ($village) => $village->where('name', 'like', '%'.$request->string('cari').'%'))->orWhereHas('regency', fn ($regency) => $regency->where('name', 'like', '%'.$request->string('cari').'%')))));
            $allPrograms = MbbrProgram::withCount(['recipients', 'recipients as recipients_completed_count' => fn ($query) => $query->where('status', 'completed'), 'recipients as recipients_process_count' => fn ($query) => $query->where('status', 'process')])->get();
            return view('frontend.pages.activities.programs', $data + [
                'title' => 'Program Kegiatan', 'programList' => $programQuery->get(), 'allPrograms' => $allPrograms, 'selectedType' => $selectedType,
                'years' => $allPrograms->pluck('fiscal_year')->filter()->unique()->sortDesc()->values(),
                'programTypes' => \App\Models\MbbrProgramType::orderBy('name')->get(),
                'programTotal' => $allPrograms->count(), 'programActive' => $allPrograms->where('status', 'active')->count(),
                'programCompleted' => $allPrograms->where('status', 'completed')->count(), 'recipientTotal' => $allPrograms->sum('recipients_count'),
            ]);
        }
        if ($page === 'layanan-pkp') {
            return view('frontend.pages.services.pkp', $data + [
                'title' => 'Layanan PKP',
                'activeProgramTypes' => MbbrProgramType::withCount('programs')->orderBy('name')->get(),
                'pkpServices' => PkpService::where('is_active', true)->orderBy('sort_order')->latest('id')->get(),
            ]);
        }
        if ($page === 'pendataan-rlth') {
            $allRlth = RlthRecord::query()->where('submission_status', 'verified');
            $filteredRlth = (clone $allRlth)->latest()->get();
            return view('frontend.pages.services.rlth', $data + [
                'title' => 'Pendataan RLTH',
                'rlthTotal' => $allRlth->count(),
                'rlthRegencies' => (clone $allRlth)->whereNotNull('regency_name')->distinct()->count('regency_name'),
                'rlthRecords' => $filteredRlth,
                'rlthYears' => (clone $allRlth)->whereNotNull('survey_year')->distinct()->orderByDesc('survey_year')->pluck('survey_year'),
                'rlthRegencyOptions' => (clone $allRlth)->whereNotNull('regency_name')->distinct()->orderBy('regency_name')->pluck('regency_name'),
                'rlthVillageOptions' => (clone $allRlth)->whereNotNull('village_name')->distinct()->orderBy('village_name')->pluck('village_name'),
                'rlthMapItems' => $filteredRlth->filter(fn ($record) => $record->latitude && $record->longitude)->map(fn ($record) => [
                    'id' => $record->id, 'name' => $record->name, 'lat' => (float) $record->latitude, 'lng' => (float) $record->longitude,
                    'village' => $record->village_name, 'regency' => $record->regency_name, 'condition' => $record->roof_damage_level,
                    'detail' => [
                        'name' => $record->name, 'year' => $record->survey_year,
                        'national_id' => $record->national_id ? str_repeat('*', max(0, strlen($record->national_id) - 4)).substr($record->national_id, -4) : null,
                        'family_card_number' => $record->family_card_number ? str_repeat('*', max(0, strlen($record->family_card_number) - 4)).substr($record->family_card_number, -4) : null,
                        'phone' => $record->phone ? str_repeat('*', max(0, strlen($record->phone) - 4)).substr($record->phone, -4) : null,
                        'address' => $record->address, 'village' => $record->village_name,
                        'province' => $record->province_name, 'district' => $record->district_name, 'regency' => $record->regency_name,
                        'family_members' => $record->family_member_count, 'pln_customer_id' => $record->pln_customer_id,
                        'national_decile' => $record->national_decile, 'provincial_decile' => $record->provincial_decile, 'regency_decile' => $record->regency_decile,
                        'national_pbi' => $record->national_pbi, 'local_pbi' => $record->local_pbi,
                        'occupation' => $record->occupation, 'income' => $record->income_range,
                        'house_ownership' => $record->house_ownership, 'land_ownership' => $record->land_ownership,
                        'other_assets' => $record->other_assets, 'foundation' => $record->foundation_condition,
                        'beam_column' => $record->beam_column_condition, 'windows' => $record->window_availability,
                        'ventilation' => $record->ventilation_availability, 'mck' => $record->mck_availability,
                        'water_source' => $record->water_source, 'electricity_source' => $record->electricity_source, 'electricity_capacity' => $record->electricity_capacity,
                        'cooking_fuel' => $record->cooking_fuel, 'toilet_facility' => $record->toilet_facility, 'toilet_type' => $record->toilet_type, 'sewage_disposal' => $record->sewage_disposal,
                        'floor_type' => $record->floor_type, 'wall_type' => $record->wall_type,
                        'roof_material' => $record->roof_material, 'roof' => $record->roof_damage_level,
                        'area' => $record->building_area, 'latitude' => $record->latitude, 'longitude' => $record->longitude,
                        'photos' => array_filter([
                            'Tampak depan' => $record->photoUrl('photo_front_path'), 'Samping kiri' => $record->photoUrl('photo_left_path'),
                            'Samping kanan' => $record->photoUrl('photo_right_path'), 'Tampak belakang' => $record->photoUrl('photo_back_path'),
                            'Atap bagian dalam' => $record->photoUrl('photo_roof_path'), 'Jendela' => $record->photoUrl('photo_window_path'), 'MCK' => $record->photoUrl('photo_mck_path'),
                        ]),
                    ],
                ])->values(),
            ]);
        }
        if ($page === 'geomap') return view('frontend.pages.maps.index', $data + [
            'title' => 'GeoMAP MBBR',
            'villages' => Village::orderBy('name')->get(),
            'programTypes' => MbbrProgramType::orderBy('id')->get(),
            'mapAreas' => MbbrArea::with(['regency', 'village'])->orderBy('name')->get(),
        ]);
        if ($page === 'data-usulan') {
            $proposals = ProposalData::query()->latest()->get();
            return view('frontend.pages.sigaprumabeta.proposals', $data + [
                'title' => 'Data Usulan',
                'proposals' => $proposals,
                'proposalYears' => $proposals->pluck('proposal_year')->filter()->unique()->sortDesc()->values(),
                'proposalRegencies' => $proposals->pluck('regency_name')->filter()->unique()->sort()->values(),
                'proposalMapItems' => $proposals->filter(fn ($proposal) => $proposal->latitude && $proposal->longitude)->map(fn ($proposal) => [
                    'id' => $proposal->id, 'lat' => (float) $proposal->latitude, 'lng' => (float) $proposal->longitude,
                    'year' => $proposal->proposal_year, 'regency' => $proposal->regency_name, 'village' => $proposal->village_name,
                ])->values(),
            ]);
        }
        if (in_array($page, ['sadata-kp', 'sadata-psu', 'kawasan-kumuh'], true)) {
            $sigaprumabetaPages = [
                'data-usulan' => ['title' => 'Data Usulan', 'icon' => 'fa-file-circle-plus', 'description' => 'Pusat informasi usulan pembangunan perumahan dan kawasan permukiman Provinsi Maluku.'],
                'sadata-kp' => ['title' => 'Sadata KP', 'icon' => 'fa-city', 'description' => 'Sistem data kawasan permukiman untuk mendukung perencanaan dan pengambilan kebijakan.'],
                'sadata-psu' => ['title' => 'Sadata PSU', 'icon' => 'fa-road', 'description' => 'Sistem data prasarana, sarana, dan utilitas umum perumahan dan permukiman.'],
                'kawasan-kumuh' => ['title' => 'Kawasan Kumuh', 'icon' => 'fa-layer-group', 'description' => 'Informasi kawasan kumuh untuk mendukung penanganan permukiman yang layak dan berkelanjutan.'],
            ];
            return view('frontend.pages.sigaprumabeta.index', $data + ['sigaprumabeta' => $sigaprumabetaPages[$page]]);
        }
        if ($page === 'galeri') {
            $galleryItems = Gallery::where('is_active', true)->latest()->get();
            return view('frontend.pages.gallery.index', $data + [
                'title' => 'Galeri',
                'galleryItems' => $galleryItems,
                'galleryGroups' => [
                    'kegiatan' => $galleryItems->where('category', 'kegiatan'),
                    'informasi' => $galleryItems->where('category', 'informasi'),
                    'video' => $galleryItems->where('category', 'video'),
                ],
            ]);
        }
        if (in_array($page, ['peraturan', 'informasi', 'unduhan'], true)) {
            $documentQuery = Document::latest('published_date')->latest();
            if ($page !== 'unduhan') $documentQuery->where('category', $page);
            return view('frontend.pages.documents.index', $data + [
                'title' => $page === 'peraturan' ? 'Peraturan' : ($page === 'informasi' ? 'Informasi' : 'Unduhan'),
                'documentPage' => $page,
                'documentList' => $documentQuery->get(),
            ]);
        }
        if ($page === 'kontak') return view('frontend.pages.contact', $data + ['title'=>'Kontak Kami']);
        if ($page === 'berita') {
            $news = Post::where('status', 'published')->whereNotNull('published_at')->latest('published_at');
            $news->when($request->filled('kategori'), fn ($query) => $query->where('category', $request->string('kategori')));
            $news->when($request->filled('cari'), fn ($query) => $query->where(fn ($search) => $search->where('title', 'like', '%'.$request->string('cari').'%')->orWhere('excerpt', 'like', '%'.$request->string('cari').'%')->orWhere('content', 'like', '%'.$request->string('cari').'%')));
            return view('frontend.pages.news.index', $data + ['title'=>'Berita','news'=>$news->paginate(9)->withQueryString(),'categories'=>Post::where('status','published')->whereNotNull('published_at')->distinct()->orderBy('category')->pluck('category')]);
        }
        if ($page !== 'home') return view('frontend.pages.content', $data + ['title' => ucwords(str_replace('-', ' ', $page))]);
        return view('frontend.pages.home', $data + ['title' => 'Beranda']);
    }
    public function storeReview(Request $request) { $data=$request->validate(['name'=>'required|string|max:100','rating'=>'required|integer|between:1,5','feedback'=>'nullable|string|max:1000']); ServiceReview::create($data); return back()->with('review_success','Terima kasih, ulasan Anda telah dikirim.'); }
    public function newsDetail(string $slug)
    {
        $post = Post::where('slug', $slug)->where('status','published')->whereNotNull('published_at')->firstOrFail();
        return view('frontend.pages.news.detail', ['page'=>'berita','title'=>$post->title,'setting'=>WebsiteSetting::first(),'post'=>$post,'related'=>Post::where('status','published')->whereNotNull('published_at')->whereKeyNot($post->id)->where('category',$post->category)->latest('published_at')->limit(3)->get()]);
    }
    public function mapData(Request $request) {
        $selectedArea = $request->filled('area_id') ? MbbrArea::find($request->integer('area_id')) : null;
        $areaGroup = trim($request->string('area_group')->toString());
        $groupRegencyIds = $areaGroup === '' ? collect() : MbbrArea::where('name', 'like', $areaGroup.' —%')->pluck('regency_id')->filter()->unique();
        $groupRegencyId = $groupRegencyIds->count() === 1 ? $groupRegencyIds->first() : null;
        $regencyId = $request->integer('regency_id') ?: $selectedArea?->regency_id ?: $groupRegencyId;
        $villageId = $request->integer('village_id') ?: $selectedArea?->village_id;
        $recipients = MbbrRecipient::with(['program.type','regency','village'])->whereNotNull('latitude')->whereNotNull('longitude')->when($regencyId,fn($q,$id)=>$q->where('regency_id',$id))->when($villageId,fn($q,$id)=>$q->where('village_id',$id))->when($request->program_type_id,fn($q,$id)=>$q->whereHas('program',fn($program)=>$program->where('mbbr_program_type_id',$id)))->get();
        $areas = MbbrArea::with(['regency','village','program'])
            ->when($selectedArea, fn($q) => $q->whereKey($selectedArea->id))
            ->when(!$selectedArea && $areaGroup !== '', fn($q) => $q->where('name', 'like', $areaGroup.' —%'))
            ->when(!$selectedArea && $areaGroup === '' && $regencyId, fn ($query) => $query->where('regency_id', $regencyId))
            ->when(!$selectedArea && $areaGroup === '' && $villageId, fn ($query) => $query->where('village_id', $villageId))
            ->get();
        $points = $recipients->map(fn($recipient)=>['type'=>'Feature','geometry'=>['type'=>'Point','coordinates'=>[(float)$recipient->longitude,(float)$recipient->latitude]],'properties'=>['feature_type'=>'recipient','id'=>$recipient->id,'name'=>$recipient->name,'program'=>$recipient->program?->name,'year'=>$recipient->program?->fiscal_year,'program_type'=>$recipient->program?->type?->name,'program_type_id'=>$recipient->program?->mbbr_program_type_id,'regency'=>$recipient->regency?->name,'village'=>$recipient->village?->name,'status'=>$recipient->status,'progress'=>(float)$recipient->progress,'companion'=>$recipient->companion_name,'condition'=>$recipient->condition,'provider'=>$recipient->provider_name,'decile'=>$recipient->decile,'material_cost'=>(float)$recipient->material_cost,'labor_cost'=>(float)$recipient->labor_cost,'photo_initial'=>$recipient->photo_initial_path ? asset('storage/'.$recipient->photo_initial_path) : null,'photo_progress'=>$recipient->photo_progress_path ? asset('storage/'.$recipient->photo_progress_path) : null]]);
        $palette=['#2563eb','#10b981','#8b5cf6','#f59e0b','#e11d48','#0891b2','#4f46e5','#65a30d','#c2410c','#0f766e','#7c3aed'];
        $areas = $areas->values()->map(function ($area, $index) use (&$palette) {
            if ($area->color) $palette[$index % count($palette)] = $area->color;
            return $area;
        });
        $polygons = $areas->values()->map(fn($area,$index)=>['type'=>'Feature','geometry'=>$area->geojson,'properties'=>['feature_type'=>'area','id'=>$area->id,'name'=>$area->name,'regency'=>$area->regency?->name,'village'=>$area->village?->name,'program'=>$area->program?->name,'category'=>str_contains($area->name,'—') ? 'Kawasan Kumuh' : 'Batas Kabupaten/Kota','color'=>$palette[$index % count($palette)]]]);
        // Warna setiap polygon wajib mengikuti warna yang disimpan saat input/import GeoJSON.
        $areaColors = $areas->pluck('color')->values();
        $polygons = $polygons->values()->map(function (array $polygon, int $index) use ($areaColors) {
            $polygon['properties']['color'] = $areaColors[$index] ?: '#2563eb';
            return $polygon;
        });
        return response()->json(['type'=>'FeatureCollection','features'=>$polygons->concat($points)->values(),'meta'=>['recipients'=>$recipients->count(),'areas'=>$areas->count(),'completed'=>$recipients->where('status','completed')->count(),'process'=>$recipients->where('status','process')->count(),'waiting'=>$recipients->where('status','waiting')->count()]]);
    }
    private function recordVisit(Request $request): void { VisitorSession::firstOrCreate(['visit_date'=>today(),'session_hash'=>hash('sha256',$request->session()->getId())]); }
    private function frontendMenu(): string { return <<<'HTML'
<ul class="navbar-nav me-auto"><li class="nav-item"><a class="nav-link" href="/"><i class="fas fa-home me-1"></i> BERANDA</a></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="fas fa-building me-1"></i> PROFIL</a><ul class="dropdown-menu"><li><a class="dropdown-item" href="/profil-dinas">Profil Dinas</a></li><li><a class="dropdown-item" href="/visi-misi">Visi Misi</a></li><li><a class="dropdown-item" href="/tugas-pokok-fungsi">Tugas Pokok & Fungsi</a></li><li><a class="dropdown-item" href="/struktur-organisasi">Struktur Organisasi</a></li><li><a class="dropdown-item" href="/profil-pejabat">Profil Pejabat Struktural</a></li></ul></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="fas fa-calendar-alt me-1"></i> KEGIATAN</a><ul class="dropdown-menu"><li><a class="dropdown-item" href="/agenda-kegiatan">Agenda Kegiatan</a></li><li><a class="dropdown-item" href="/program-kegiatan">Program Kegiatan</a></li></ul></li><li class="nav-item"><a class="nav-link" href="/berita"><i class="fas fa-newspaper me-1"></i> BERITA</a></li><li class="nav-item"><a class="nav-link" href="/geomap"><i class="fas fa-map-marker-alt me-1"></i> GEO MAP</a></li><li class="nav-item"><a class="nav-link" href="/galeri"><i class="fas fa-images me-1"></i> GALERI</a></li><li class="nav-item"><a class="nav-link" href="/peraturan"><i class="fas fa-file-contract me-1"></i> PERATURAN</a></li><li class="nav-item"><a class="nav-link" href="/informasi"><i class="fas fa-info-circle me-1"></i> INFORMASI</a></li><li class="nav-item"><a class="nav-link" href="/unduhan"><i class="fas fa-download me-1"></i> UNDUHAN</a></li><li class="nav-item"><a class="nav-link" href="/kontak"><i class="fas fa-phone me-1"></i> KONTAK</a></li></ul></div></div></nav>
HTML; }
}
