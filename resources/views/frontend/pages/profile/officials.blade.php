@extends('frontend.layouts.public')

@section('content')
<style>
    .official-page { padding: 42px 0 70px; background: linear-gradient(180deg,#f4fbfc 0,#fff 45%); }
    .official-title { margin-bottom: 26px; }
    .official-title h1 { color:#173b50; font-size:2.15rem; font-weight:800; letter-spacing:.2px; }
    .official-title h1::after { content:''; display:block; width:78px; height:5px; margin-top:14px; border-radius:10px; background:linear-gradient(90deg,#1765d7,#b99b59); }
    .official-title p { color:#6b7c86; font-size:1.05rem; }
    .official-filter { padding:25px; margin-bottom:32px; border:1px solid #dcecf0; border-radius:20px; background:#fff; box-shadow:0 12px 32px #16425812; }
    .official-filter label { color:#28475a; font-weight:800; font-size:.84rem; }
    .official-filter .form-select { min-height:46px; border:1px solid #cddfe6; border-radius:11px; color:#294557; font-size:.9rem; }
    .official-filter .form-select:focus { border-color:#1970d4; box-shadow:0 0 0 .2rem #1970d422; }
    .filter-button { height:46px; border:0; border-radius:11px; background:linear-gradient(135deg,#1768cf,#0f4eaa); font-weight:700; }
    .reset-filter { color:#54737f; font-weight:700; text-decoration:none; }
    .official-card { height:100%; overflow:hidden; border:0; border-radius:20px; background:#fff; box-shadow:0 10px 30px #16384d17; transition:transform .25s,box-shadow .25s; }
    .official-card:hover { transform:translateY(-7px); box-shadow:0 20px 40px #16384d2b; }
    .official-card-top { position:relative; min-height:243px; padding:30px 20px 23px; overflow:hidden; text-align:center; color:#fff; background:linear-gradient(140deg,#155da9,#2587c3); }
    .official-card-top::before { content:''; position:absolute; inset:0; opacity:.15; background:radial-gradient(circle at 18% 18%,#fff 0 4px,transparent 5px),radial-gradient(circle at 85% 82%,#fff 0 7px,transparent 8px); background-size:42px 42px,75px 75px; }
    .official-echel { position:absolute; top:16px; right:16px; z-index:1; padding:6px 12px; border-radius:20px; background:#c7a765; color:#fff; font-size:.75rem; font-weight:800; box-shadow:0 4px 10px #5b431c55; }
    .official-photo { position:relative; z-index:1; width:120px; height:120px; margin:0 auto 14px; overflow:hidden; border:5px solid #fff; border-radius:50%; background:#53616a; box-shadow:0 8px 19px #061f3d55; }
    .official-photo img { width:100%; height:100%; object-fit:cover; transition:transform .25s; }
    .official-card:hover .official-photo img { transform:scale(1.08); }
    .official-name { position:relative; z-index:1; margin:0; font-size:1.05rem; font-weight:800; line-height:1.3; }
    .official-position { position:relative; z-index:1; min-height:38px; margin:7px 0 0; font-size:.82rem; font-weight:600; line-height:1.3; }
    .official-body { padding:22px 23px 24px; }
    .official-info { min-height:106px; }
    .info-row { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid #e7eef1; }
    .info-row i { width:18px; padding-top:2px; color:#1768cf; text-align:center; }
    .info-row small { display:block; color:#78909b; font-size:.73rem; font-weight:700; }
    .info-row span { color:#344f5e; font-size:.85rem; line-height:1.35; }
    .detail-button { border:1px solid #1768cf; border-radius:10px; color:#1768cf; font-weight:800; }
    .detail-button:hover { background:#1768cf; color:#fff; }
    .detail-modal .modal-content { overflow:hidden; border:0; border-radius:20px; }
    .detail-modal .modal-header { border:0; color:#fff; background:linear-gradient(135deg,#155da9,#2587c3); }
    .detail-profile { border-radius:15px; background:#f2f8fa; }
    .detail-photo { width:160px; height:160px; object-fit:cover; border:5px solid #fff; border-radius:50%; box-shadow:0 8px 20px #173f5a28; }
    .detail-table th { width:39%; color:#55717e; font-size:.84rem; font-weight:800; }
    .detail-table td { color:#284654; font-size:.9rem; }
    @media (max-width:576px) { .official-title h1 { font-size:1.7rem; } .official-filter { padding:18px; } }
</style>

<main class="official-page">
    <div class="container">
        <header class="official-title">
            <h1>PROFIL PEJABAT STRUKTURAL</h1>
            <p class="mb-0">Penanggung jawab bidang pada Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku.</p>
        </header>

        <form class="official-filter" method="GET" action="/profil-pejabat">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6"><label class="form-label">Jabatan</label><select name="jabatan" class="form-select"><option value="">Semua Jabatan</option>@foreach($positionOptions as $option)<option value="{{ $option }}" @selected(request('jabatan') === $option)>{{ $option }}</option>@endforeach</select></div>
                <div class="col-lg-3 col-md-6"><label class="form-label">Eselon</label><select name="eselon" class="form-select"><option value="">Semua Eselon</option>@foreach($echelonOptions as $option)<option value="{{ $option }}" @selected(request('eselon') === $option)>{{ $option }}</option>@endforeach</select></div>
                <div class="col-lg-3 col-md-6"><label class="form-label">Bidang / Unit Kerja</label><select name="unit" class="form-select"><option value="">Semua Bidang / Unit</option>@foreach($unitOptions as $option)<option value="{{ $option }}" @selected(request('unit') === $option)>{{ $option }}</option>@endforeach</select></div>
                <div class="col-lg-3 col-md-6 d-flex gap-2"><button class="btn btn-primary filter-button flex-grow-1"><i class="fas fa-filter me-2"></i>Filter</button><a href="/profil-pejabat" class="btn btn-light border px-3 d-flex align-items-center" title="Reset filter"><i class="fas fa-rotate-left"></i></a></div>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3"><span class="text-secondary small">Menampilkan <strong>{{ $officials->count() }}</strong> pejabat</span>@if(request()->hasAny(['jabatan','eselon','unit']))<a class="reset-filter" href="/profil-pejabat"><i class="fas fa-xmark me-1"></i>Hapus filter</a>@endif</div>
        <div class="row g-4">
            @forelse($officials as $official)
                <div class="col-lg-4 col-md-6">
                    <article class="official-card">
                        <div class="official-card-top">
                            @if($official->echelon)<span class="official-echel">{{ $official->echelon }}</span>@endif
                            <div class="official-photo"><img src="{{ $official->photo_path ? asset($official->photo_path) : asset('assets/img/user.png') }}" alt="{{ $official->name }}"></div>
                            <h2 class="official-name">{{ $official->name }}</h2><p class="official-position">{{ $official->position }}</p>
                        </div>
                        <div class="official-body">
                            <div class="official-info">
                                @if($official->nip)<div class="info-row"><i class="fas fa-id-card"></i><div><small>NIP</small><span>{{ $official->nip }}</span></div></div>@endif
                                @if($official->education)<div class="info-row"><i class="fas fa-graduation-cap"></i><div><small>Pendidikan</small><span>{{ $official->education }}</span></div></div>@endif
                                @if($official->unit)<div class="info-row"><i class="fas fa-sitemap"></i><div><small>Bidang / Unit Kerja</small><span>{{ $official->unit }}</span></div></div>@endif
                            </div>
                            <button class="btn detail-button w-100 mt-3" data-bs-toggle="modal" data-bs-target="#officialDetail{{ $official->id }}"><i class="fas fa-eye me-2"></i>Lihat Detail Profil</button>
                        </div>
                    </article>
                </div>

                <div class="modal fade detail-modal" id="officialDetail{{ $official->id }}" tabindex="-1" aria-labelledby="officialDetailLabel{{ $official->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header py-3"><h3 class="modal-title h5 mb-0" id="officialDetailLabel{{ $official->id }}">Detail Profil Pejabat</h3><button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
                            <div class="modal-body p-md-4"><div class="row g-4">
                                <div class="col-md-4"><div class="detail-profile p-4 text-center"><img class="detail-photo" src="{{ $official->photo_path ? asset($official->photo_path) : asset('assets/img/user.png') }}" alt="{{ $official->name }}"><h4 class="mt-3 mb-1 fs-5 fw-bold" style="color:#254658">{{ $official->name }}</h4><p class="mb-2 small text-primary fw-bold">{{ $official->position }}</p>
                                    @if($official->echelon)<span class="badge rounded-pill text-bg-warning px-3 py-2">{{ $official->echelon }}</span>@endif
                                </div></div>
                                <div class="col-md-8">
                                    <table class="table table-sm detail-table mb-0"><tbody>
                                        @if($official->nip)<tr><th>NIP</th><td>{{ $official->nip }}</td></tr>@endif
                                        @if($official->place_of_birth || $official->date_of_birth)<tr><th>Tempat / Tanggal Lahir</th><td>{{ collect([$official->place_of_birth, optional($official->date_of_birth)->translatedFormat('d F Y')])->filter()->join(', ') }}</td></tr>@endif
                                        @if($official->rank)<tr><th>Pangkat / Golongan</th><td>{{ $official->rank }}</td></tr>@endif
                                        @if($official->position_started_at)<tr><th>TMT Jabatan</th><td>{{ $official->position_started_at->translatedFormat('d F Y') }}</td></tr>@endif
                                        @if($official->unit)<tr><th>Bidang / Unit Kerja</th><td>{{ $official->unit }}</td></tr>@endif
                                        @if($official->education)<tr><th>Pendidikan Terakhir</th><td>{{ $official->education }}</td></tr>@endif
                                        @if($official->appointment_number)<tr><th>Surat Keputusan</th><td>SK No. {{ $official->appointment_number }}</td></tr>@endif
                                    </tbody></table>
                                    @if($official->bio)<div class="mt-3"><h5 class="fs-6 fw-bold">Profil Singkat</h5><p class="text-secondary mb-0">{{ $official->bio }}</p></div>@endif
                                    @if($official->education_history)<div class="mt-3"><h5 class="fs-6 fw-bold">Riwayat Pendidikan</h5><div class="text-secondary small">{!! nl2br(e($official->education_history)) !!}</div></div>@endif
                                    @if($official->career_history)<div class="mt-3"><h5 class="fs-6 fw-bold">Riwayat Jabatan</h5><div class="text-secondary small">{!! nl2br(e($official->career_history)) !!}</div></div>@endif
                                </div>
                            </div></div>
                            <div class="modal-footer"><button class="btn btn-outline-secondary" data-bs-dismiss="modal"><i class="fas fa-xmark me-1"></i>Tutup</button></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light border text-center py-5"><i class="fas fa-filter fs-3 d-block mb-2 text-secondary"></i>Data pejabat tidak ditemukan untuk filter yang dipilih.</div></div>
            @endforelse
        </div>
    </div>
</main>
@endsection
