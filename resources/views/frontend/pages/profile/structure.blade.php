@extends('frontend.layouts.public')

@section('content')
<style>
    .org-page { padding: 38px 0 75px; background: #e6f4fa; }
    .org-scroll { overflow-x: auto; padding-bottom: 8px; }
    .org-canvas { position: relative; min-width: 1420px; overflow: hidden; padding: 24px 48px 55px; border-radius: 8px; background: linear-gradient(145deg, #48b7ec, #51c5e8 52%, #4fa8d2); box-shadow: 0 20px 45px #0b3b5c35; }
    .org-canvas::before { content: ''; position: absolute; inset: auto 0 0; height: 310px; opacity: .34; background: linear-gradient(90deg, transparent 4%, #1e6e98 4% 11%, transparent 11% 18%, #1f779f 18% 28%, transparent 28% 35%, #1e6e98 35% 43%, transparent 43% 52%, #257ba0 52% 65%, transparent 65% 72%, #1c6f99 72% 81%, transparent 81% 90%, #23789f 90%); clip-path: polygon(0 45%,6% 45%,6% 15%,11% 15%,11% 55%,18% 55%,18% 0,27% 0,27% 68%,35% 68%,35% 34%,43% 34%,43% 52%,52% 52%,52% 12%,65% 12%,65% 62%,72% 62%,72% 25%,81% 25%,81% 58%,90% 58%,90% 5%,100% 5%,100% 100%,0 100%); }
    .org-canvas::after { content: ''; position: absolute; left: 0; right: 0; bottom: 38px; height: 5px; background: repeating-linear-gradient(90deg, #e5d071 0 52px, transparent 52px 82px); opacity: .8; }
    .org-head { position: relative; z-index: 3; text-align: center; color: #071f2d; }
    .org-head h1 { margin: 0; font-size: 31px; font-weight: 900; }
    .org-head p { margin: 0; font-size: 21px; font-weight: 800; }
    .org-head hr { width: 60%; margin: 5px auto; border: 0; border-top: 3px solid #102b38; }
    .org-logo { position: absolute; top: 28px; z-index: 4; width: 112px; height: 112px; object-fit: contain; }
    .org-logo.left { left: 38px; }
    .org-logo.right { right: 38px; }
    .diagram { position: relative; z-index: 3; height: 735px; margin-top: 20px; }
    .org-connectors { position: absolute; inset: 0; z-index: 1; width: 100%; height: 100%; overflow: visible; pointer-events: none; }
    .org-connectors path { fill: none; stroke: #edf9fb; stroke-width: 3; stroke-linecap: round; stroke-linejoin: round; }
    .org-connectors circle { fill: #153c9e; stroke: #edf9fb; stroke-width: 2; }
    .org-node { position: absolute; z-index: 2; box-sizing: border-box; width: 285px; min-height: 70px; padding: 10px 16px; text-align: center; background: #fff; border: 4px solid #272b95; border-radius: 25px; box-shadow: 0 5px 12px #10384c4d; }
    .org-node.red { border-color: #d9403e; }
    .org-node.green { border-color: #8ecb32; border-radius: 23px; }
    .org-node h3 { margin: 0; padding-bottom: 5px; color: #1d2730; font-size: 14px; font-weight: 900; line-height: 1.16; border-bottom: 1px solid #9ba6a9; }
    .org-node p { margin: 5px 0 0; color: #27323a; font-size: 12px; font-weight: 700; line-height: 1.22; }
    .org-node .eselon { margin-top: 4px; color: #69767e; font-size: 10px; }
    .head-node { top: 0; left: 510px; width: 304px; }
    .secretary-node { top: 130px; left: 890px; width: 310px; }
    .secretariat-unit { top: 270px; width: 245px; min-height: 76px; }
    .secretariat-unit.one { left: 570px; }
    .secretariat-unit.two { left: 835px; }
    .secretariat-unit.three { left: 1100px; }
    .department { top: 430px; width: 285px; height: 100px; }
    .department.d-0 { left: 15px; }
    .department.d-1 { left: 345px; }
    .department.d-2 { left: 675px; }
    .department.d-3 { left: 1005px; }
    .unit-stack { position: absolute; top: 548px; width: 285px; z-index: 2; display: flex; flex-direction: column; gap: 14px; }
    .unit-stack.u-0 { left: 15px; }
    .unit-stack.u-1 { left: 345px; }
    .unit-stack.u-2 { left: 675px; }
    .unit-stack.u-3 { left: 1005px; }
    .unit-stack .org-node { position: relative; width: 285px; height: 90px; min-height: 90px; }
    .org-caption { position: relative; z-index: 3; margin: 24px 0 0; color: #eaf7f8; font-size: 13px; text-align: center; }
    @media (max-width: 991px) { .org-canvas { border-radius: 0; } .org-logo { display: none; } }
</style>

@php
    $head = $officials->first(fn ($item) => strtolower($item->position) === 'kepala dinas');
    $secretary = $officials->first(fn ($item) => strtolower($item->position) === 'sekretaris dinas');
    $subUnits = $officials->filter(fn ($item) => str_contains($item->position, 'KASUBAG'))->values();
    $organizationUnits = \App\Models\OrganizationalUnit::where('is_active', true)->orderBy('sort_order')->get();
    $secretariatUnits = $organizationUnits->where('parent_key', 'sekretariat')->values();
    $departments = $officials->filter(fn ($item) => str_contains($item->position, 'BIDANG'))->values();
    $keys = ['rumah-umum', 'rumah-swadaya', 'kawasan-permukiman', 'prasarana-pembiayaan'];
@endphp

<main class="org-page">
    <div class="container-fluid px-lg-4">
        <div class="org-scroll">
            <section class="org-canvas">
                <img class="org-logo left" src="{{ asset('assets/img/logo.png') }}" alt="Lambang Maluku">
                <img class="org-logo right" src="{{ asset('assets/img/logo.png') }}" alt="Logo Dinas">

                <header class="org-head">
                    <h1>STRUKTUR ORGANISASI</h1>
                    <p>DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN PROVINSI MALUKU</p>
                    <hr>
                </header>

                <div class="diagram">
                    {{-- Garis konektor memakai koordinat tetap agar selalu tepat pada kotak jabatan. --}}
                    <svg class="org-connectors" viewBox="0 0 1324 735" preserveAspectRatio="none" aria-hidden="true">
                        <defs>
                            <marker id="org-arrow" markerWidth="9" markerHeight="9" refX="7" refY="4.5" orient="auto" markerUnits="strokeWidth">
                                <path d="M0,0 L8,4.5 L0,9 Z" fill="#edf9fb" />
                            </marker>
                        </defs>
                        <path d="M662 78 V105 H1045 V126" />
                        <circle cx="662" cy="78" r="5" /><circle cx="1045" cy="126" r="5" />
                        <path d="M1045 207 V245 H692 V266 M1045 245 H958 V266 M1045 245 H1223 V266" />
                        <circle cx="1045" cy="207" r="5" /><circle cx="692" cy="266" r="5" /><circle cx="958" cy="266" r="5" /><circle cx="1223" cy="266" r="5" />
                        <path d="M662 78 V390 H157 V426 M662 390 H487 V426 M662 390 H817 V426 M662 390 H1147 V426" />
                        <circle cx="662" cy="78" r="5" /><circle cx="157" cy="426" r="5" /><circle cx="487" cy="426" r="5" /><circle cx="817" cy="426" r="5" /><circle cx="1147" cy="426" r="5" />
                        <path d="M157 530 V544" marker-end="url(#org-arrow)" /><path d="M487 530 V544" marker-end="url(#org-arrow)" /><path d="M817 530 V544" marker-end="url(#org-arrow)" /><path d="M1147 530 V544" marker-end="url(#org-arrow)" />
                        <path d="M157 638 V648" marker-end="url(#org-arrow)" /><path d="M487 638 V648" marker-end="url(#org-arrow)" /><path d="M817 638 V648" marker-end="url(#org-arrow)" /><path d="M1147 638 V648" marker-end="url(#org-arrow)" />
                        <circle cx="157" cy="530" r="4" /><circle cx="487" cy="530" r="4" /><circle cx="817" cy="530" r="4" /><circle cx="1147" cy="530" r="4" />
                    </svg>

                    @if ($head)
                        <article class="org-node red head-node"><h3>KEPALA DINAS</h3><p>{{ $head->name }}</p><div class="eselon">{{ $head->echelon }}</div></article>
                    @endif

                    @if ($secretary)
                        <article class="org-node secretary-node"><h3>SEKRETARIS DINAS</h3><p>{{ $secretary->name }}</p><div class="eselon">{{ $secretary->echelon }}</div></article>
                    @endif

                    @php($supportUnits = $subUnits->concat($secretariatUnits)->take(3))
                    @for ($i = 0; $i < 3; $i++)
                        @php($unit = $supportUnits->get($i))
                        <article class="org-node green secretariat-unit {{ ['one', 'two', 'three'][$i] }}">
                            <h3>{{ $unit?->position ?? $unit?->name ?? 'JABATAN FUNGSIONAL' }}</h3>
                            <p>{{ $unit?->name ?? 'Jabatan Fungsional' }}</p>
                        </article>
                    @endfor

                    @foreach ($departments->take(4) as $index => $department)
                        @php($key = $keys[$index])
                        <article class="org-node department d-{{ $index }}"><h3>{{ str_replace('KEPALA BIDANG', 'KABID', $department->position) }}</h3><p>{{ $department->name }}</p><div class="eselon">{{ $department->echelon }}</div></article>
                        <div class="unit-stack u-{{ $index }}">
                            @forelse ($organizationUnits->where('parent_key', $key) as $unit)
                                <article class="org-node green"><h3>{{ $unit->name }}</h3><p>Jabatan Fungsional</p></article>
                            @empty
                                <article class="org-node green"><h3>JABATAN FUNGSIONAL TERKAIT</h3><p>Data belum ditambahkan</p></article>
                            @endforelse
                        </div>
                    @endforeach
                </div>

                <p class="org-caption">Bagan organisasi berdasarkan data struktural Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku</p>
            </section>
        </div>
    </div>
</main>
@endsection
