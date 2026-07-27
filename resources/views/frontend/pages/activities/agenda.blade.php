@extends('frontend.layouts.public')

@section('content')
<style>
    .agenda-page { padding:42px 0 72px; background:linear-gradient(180deg,#eff9fb 0,#fff 52%); }
    .agenda-heading { margin-bottom:25px; }
    .agenda-heading h1 { margin:0; color:#193f54; font-size:2.1rem; font-weight:900; }
    .agenda-heading p { margin:9px 0 0; color:#71828b; }
    .agenda-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px; }
    .agenda-stat { position:relative; overflow:hidden; padding:21px 18px; border-radius:16px; color:#fff; background:linear-gradient(135deg,#1768b8,#2a95c8); box-shadow:0 12px 27px #17557d24; }
    .agenda-stat:nth-child(2) { background:linear-gradient(135deg,#177a8a,#38a798); }.agenda-stat:nth-child(3) { background:linear-gradient(135deg,#a47b32,#d2ab56); }.agenda-stat:nth-child(4) { background:linear-gradient(135deg,#445b85,#617da8); }
    .agenda-stat i { position:absolute; right:17px; bottom:-12px; font-size:4.2rem; opacity:.15; }.agenda-stat strong { display:block; font-size:1.8rem; line-height:1; }.agenda-stat span { font-size:.83rem; font-weight:700; opacity:.95; }
    .agenda-panel { padding:28px; border:1px solid #dcecef; border-radius:20px; background:rgba(255,255,255,.95); box-shadow:0 14px 35px #173e5414; }
    .agenda-panel-title { margin:0 0 20px; color:#1b4359; font-size:1.25rem; font-weight:900; }
    .agenda-filters { display:flex; flex-wrap:wrap; gap:9px; padding-bottom:23px; margin-bottom:22px; border-bottom:1px solid #e4eef1; }
    .agenda-filter { border:1px solid #c9dce2; border-radius:20px; padding:8px 16px; color:#55717e; background:#fff; font-size:.84rem; font-weight:800; transition:.2s; }.agenda-filter:hover,.agenda-filter.active { color:#fff; border-color:#1768b8; background:#1768b8; }
    .agenda-list { display:grid; gap:16px; }.agenda-card { display:grid; grid-template-columns:112px 1fr; overflow:hidden; border:1px solid #e0ebee; border-radius:15px; background:#fff; transition:.22s; }.agenda-card:hover { transform:translateY(-3px); box-shadow:0 12px 25px #173f5420; }
    .agenda-date { display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:140px; color:#fff; background:linear-gradient(155deg,#1768b8,#2a9dc9); }.agenda-date strong { font-size:2.3rem; line-height:1; }.agenda-date span { font-size:.8rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }.agenda-date small { margin-top:5px; font-size:.72rem; opacity:.9; }
    .agenda-content { padding:19px 22px; }.agenda-content h2 { margin:0 0 8px; color:#274757; font-size:1.1rem; font-weight:900; }.agenda-content p { margin:8px 0 13px; color:#71818a; font-size:.9rem; line-height:1.55; }.agenda-meta { display:flex; flex-wrap:wrap; gap:13px 21px; color:#66808d; font-size:.81rem; }.agenda-meta i { width:16px; color:#1768b8; }.agenda-status { margin-left:auto; padding:5px 10px; border-radius:20px; font-size:.72rem; font-weight:900; text-transform:capitalize; }.status-scheduled { color:#1768b8; background:#e5f1ff; }.status-ongoing { color:#147b6f; background:#dcf5ee; }.status-completed { color:#64717a; background:#edf0f2; }.status-cancelled,.status-draft { color:#965f30; background:#fff0df; }
    .agenda-empty { padding:55px 20px; color:#73838c; text-align:center; }.agenda-empty i { display:block; margin-bottom:12px; color:#a5b6bc; font-size:2.5rem; }
    @media(max-width:767px) { .agenda-heading h1{font-size:1.75rem}.agenda-stats{grid-template-columns:repeat(2,1fr)}.agenda-panel{padding:19px}.agenda-card{grid-template-columns:78px 1fr}.agenda-date{min-height:100%;}.agenda-date strong{font-size:1.8rem}.agenda-content{padding:16px}.agenda-status{margin-left:0} }
</style>

<main class="agenda-page"><div class="container">
    <header class="agenda-heading"><h1>AGENDA KEGIATAN</h1><p>Informasi jadwal kegiatan Dinas Perumahan dan Kawasan Permukiman Provinsi Maluku.</p></header>
    <section class="agenda-stats" aria-label="Statistik agenda">
        <div class="agenda-stat"><i class="fas fa-calendar-days"></i><strong>{{ $agendaTotal }}</strong><span>Total Agenda</span></div>
        <div class="agenda-stat"><i class="fas fa-spinner"></i><strong>{{ $agendaOngoing }}</strong><span>Sedang Berlangsung</span></div>
        <div class="agenda-stat"><i class="fas fa-calendar-check"></i><strong>{{ $agendaScheduled }}</strong><span>Terjadwal</span></div>
        <div class="agenda-stat"><i class="fas fa-clock"></i><strong>{{ $agendaUpcoming }}</strong><span>Mendatang (7 Hari)</span></div>
    </section>
    <section class="agenda-panel"><h2 class="agenda-panel-title"><i class="fas fa-calendar-check me-2 text-primary"></i>Agenda Kegiatan</h2>
        <div class="agenda-filters" role="tablist"><button class="agenda-filter active" data-filter="all">Semua</button><button class="agenda-filter" data-filter="upcoming">Mendatang</button><button class="agenda-filter" data-filter="ongoing">Berlangsung</button><button class="agenda-filter" data-filter="completed">Selesai</button><button class="agenda-filter" data-filter="latest">Terbaru</button></div>
        <div class="agenda-list" id="agendaList">
            @forelse($allAgendas as $agenda)
                @php($isUpcoming = $agenda->start_date && $agenda->start_date->isFuture())
                <article class="agenda-card" data-status="{{ $agenda->status }}" data-upcoming="{{ $isUpcoming ? 'true' : 'false' }}">
                    <div class="agenda-date"><strong>{{ optional($agenda->start_date)->format('d') }}</strong><span>{{ optional($agenda->start_date)->translatedFormat('M') }}</span><small>{{ optional($agenda->start_date)->format('Y') }}</small></div>
                    <div class="agenda-content"><h2>{{ $agenda->title }}</h2>@if($agenda->description)<p>{{ $agenda->description }}</p>@endif<div class="agenda-meta"><span><i class="fas fa-clock"></i>{{ $agenda->start_time ? substr($agenda->start_time,0,5) : 'Waktu menyusul' }}@if($agenda->end_time) – {{ substr($agenda->end_time,0,5) }}@endif</span><span><i class="fas fa-location-dot"></i>{{ $agenda->location ?: 'Lokasi menyusul' }}</span><span class="agenda-status status-{{ $agenda->status }}">{{ $agenda->status === 'scheduled' ? 'Terjadwal' : ($agenda->status === 'ongoing' ? 'Berlangsung' : ($agenda->status === 'completed' ? 'Selesai' : $agenda->status)) }}</span></div></div>
                </article>
            @empty
                <div class="agenda-empty"><i class="fas fa-calendar-xmark"></i>Belum ada agenda kegiatan yang dipublikasikan.</div>
            @endforelse
        </div>
        <div class="agenda-empty d-none" id="filterEmpty"><i class="fas fa-filter-circle-xmark"></i>Tidak ada agenda pada filter ini.</div>
    </section>
</div></main>
<script>
document.querySelectorAll('.agenda-filter').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.agenda-filter').forEach(item => item.classList.remove('active')); button.classList.add('active');
    let visible = 0; document.querySelectorAll('#agendaList .agenda-card').forEach(card => { const show = button.dataset.filter === 'all' || (button.dataset.filter === 'upcoming' && card.dataset.upcoming === 'true') || card.dataset.status === button.dataset.filter || button.dataset.filter === 'latest'; card.classList.toggle('d-none', !show); if(show) visible++; });
    document.getElementById('filterEmpty').classList.toggle('d-none', visible !== 0);
}));
</script>
@endsection
