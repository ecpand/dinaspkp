@include('console.nav', ['title' => 'Dashboard LAWAMENA'])

<style>
    .lawamena-hero{position:relative;overflow:hidden;padding:32px;border-radius:20px;background:linear-gradient(125deg,#102f42,#1d5b74 64%,#4f97a9);box-shadow:0 16px 36px #143c502b;color:#fff}.lawamena-hero:before,.lawamena-hero:after{position:absolute;border:1px solid #ffffff28;border-radius:50%;content:''}.lawamena-hero:before{width:330px;height:330px;top:-185px;right:-70px}.lawamena-hero:after{width:190px;height:190px;right:120px;bottom:-150px}.lawamena-hero>*{position:relative;z-index:1}.lawamena-kicker{color:#f0d18d;font-size:.72rem;font-weight:900;letter-spacing:.16em}.lawamena-hero h2{max-width:690px;margin:8px 0 11px;font-size:1.85rem;font-weight:900;line-height:1.2}.lawamena-hero p{max-width:780px;margin:0;color:#d8eaf0;font-size:.92rem;line-height:1.7}.lawamena-hero .btn{margin-top:20px;border-radius:10px}.dashboard-stat{position:relative;overflow:hidden;border-left:4px solid var(--stat-color,#1c6e9f)!important}.dashboard-stat:after{position:absolute;width:85px;height:85px;right:-27px;bottom:-38px;border-radius:50%;background:var(--stat-color,#1c6e9f);content:'';opacity:.08}.dashboard-stat i{color:var(--stat-color,#1c6e9f);font-size:1.42rem}.dashboard-stat small{display:block;margin-top:13px;color:#78909a;font-size:.7rem;font-weight:800;letter-spacing:.08em}.dashboard-stat strong{display:block;margin-top:4px;color:#21485c;font-size:1.9rem;line-height:1}.dashboard-section-title{color:#244b5e;font-size:1.02rem;font-weight:900}.lawamena-info{height:100%;padding:23px;border:1px solid #e1edf0;border-radius:15px;background:#fbfdfd}.lawamena-info .info-icon{display:grid;width:38px;height:38px;place-items:center;border-radius:11px;background:#e4f2f7;color:#176897}.lawamena-info h3{margin:13px 0 8px;color:#24495b;font-size:1rem;font-weight:900}.lawamena-info p{margin:0;color:#647b85;font-size:.82rem;line-height:1.65}.activity-row{display:flex;gap:12px;padding:13px 0;border-bottom:1px solid #edf2f4}.activity-row:last-child{border-bottom:0}.activity-date{display:grid;flex:0 0 42px;width:42px;height:42px;place-items:center;border-radius:10px;background:#e7f4f7;color:#24708a;font-size:.7rem;font-weight:900;text-align:center;line-height:1.15}.activity-row h3{margin:0 0 3px;color:#345568;font-size:.86rem;font-weight:800}.activity-row p{margin:0;color:#82969e;font-size:.72rem}.type-progress{height:7px;border-radius:9px}.review-quote{padding:12px 0;border-bottom:1px solid #edf2f4}.review-quote:last-child{border-bottom:0}.review-quote strong{font-size:.82rem;color:#385768}.review-quote p{margin:4px 0 0;color:#738992;font-size:.77rem;line-height:1.5}.dashboard-empty{padding:30px 10px;color:#82959d;text-align:center;font-size:.82rem}
</style>

<section class="lawamena-hero mb-4">
    <span class="lawamena-kicker"><i class="fa fa-database me-2"></i>SISTEM INFORMASI PERUMAHAN & PERMUKIMAN</span>
    <h2>LAWAMENA MALUKU</h2>
    <p>Basis Data dan Informasi Lingkup Perumahan Permukiman Provinsi Maluku untuk mendukung pembangunan rumah swadaya, rumah umum bagi Masyarakat Berpenghasilan Rendah (MBR), penataan kawasan, serta penanganan rumah akibat bencana alam maupun sosial.</p>
    <a href="/console/program-mbbr" class="btn btn-light text-primary fw-bold"><i class="fa fa-chart-pie me-2"></i>Buka Dashboard MBBR</a>
</section>

<section class="row g-4 mb-4">
    @foreach([
        ['fa-users', 'Penerima MBBR', $recipients, '#2277a1'],
        ['fa-diagram-project', 'Sub Program', $programs, '#16a07e'],
        ['fa-calendar-days', 'Agenda Kegiatan', $agendas, '#b07b21'],
        ['fa-user-shield', 'Pengguna Aktif', $users, '#7755bc'],
    ] as [$icon, $label, $total, $color])
        <div class="col-sm-6 col-xl-3"><div class="card dashboard-stat p-4 h-100" style="--stat-color:{{ $color }}"><i class="fa {{ $icon }}"></i><small>{{ $label }}</small><strong>{{ number_format($total, 0, ',', '.') }}</strong></div></div>
    @endforeach
</section>

<section class="row g-4 mb-4">
    <div class="col-xl-7">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="dashboard-section-title mb-0"><i class="fa fa-chart-simple text-primary me-2"></i>Status Penerima MBBR</h2><a href="/console/program-mbbr/data-penerima" class="btn btn-sm btn-outline-primary">Kelola Penerima</a></div>
            @php($statusData = [['Selesai','completed','#16a07e'], ['Dalam Proses','process','#e59719'], ['Menunggu','waiting','#2686b8']])
            @foreach($statusData as [$label, $status, $color])
                @php($count = $recipientByStatus[$status] ?? 0)
                <div class="mb-3"><div class="d-flex justify-content-between small mb-1"><strong>{{ $label }}</strong><span class="text-secondary">{{ $count }} penerima · {{ $recipients ? round(($count / $recipients) * 100) : 0 }}%</span></div><div class="progress type-progress"><div class="progress-bar" style="width:{{ $recipients ? ($count / $recipients) * 100 : 0 }}%;background:{{ $color }}"></div></div></div>
            @endforeach
            <hr>
            <div class="row g-3">
                @forelse($programTypes as $type)
                    <div class="col-md-4"><div class="rounded-3 border p-3 h-100"><small class="text-secondary d-block mb-1">{{ $type->code }}</small><strong class="d-block" style="font-size:.85rem">{{ $type->name }}</strong><span class="text-primary small fw-bold">{{ $type->programs_count }} sub program</span></div></div>
                @empty
                    <div class="col-12 text-secondary small">Jenis program belum tersedia.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center"><h2 class="dashboard-section-title mb-0"><i class="fa fa-calendar-check text-primary me-2"></i>Agenda Terdekat</h2><a href="/console/agenda" class="small fw-bold text-decoration-none">Lihat semua</a></div>
            @forelse($upcomingAgendas as $agenda)
                <article class="activity-row"><div class="activity-date">{{ optional($agenda->start_date)->format('d') }}<br><span>{{ strtoupper(optional($agenda->start_date)->translatedFormat('M')) }}</span></div><div><h3>{{ $agenda->title }}</h3><p><i class="fa fa-location-dot me-1"></i>{{ $agenda->location ?: 'Lokasi belum diisi' }} · {{ $agenda->start_time ? \Carbon\Carbon::parse($agenda->start_time)->format('H:i') : '-' }} WIT</p></div></article>
            @empty
                <div class="dashboard-empty"><i class="fa fa-calendar-xmark fs-4 d-block mb-2"></i>Belum ada agenda terjadwal.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-xl-8">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center gap-2 mb-3"><span class="info-icon"><i class="fa fa-lightbulb"></i></span><div><h2 class="dashboard-section-title mb-0">Tentang Inovasi LAWAMENA MALUKU</h2><small class="text-secondary">Pusat data dan informasi perumahan serta kawasan permukiman Maluku.</small></div></div>
            <div class="row g-3">
                <div class="col-md-4"><article class="lawamena-info"><span class="info-icon"><i class="fa fa-bullseye"></i></span><h3>Tujuan</h3><p>Memenuhi kebutuhan penyelenggaraan pembangunan perumahan dan kawasan permukiman demi kepentingan masyarakat Maluku.</p></article></div>
                <div class="col-md-4"><article class="lawamena-info"><span class="info-icon"><i class="fa fa-server"></i></span><h3>Fungsi</h3><p>Pusat data Pokja PKP, sarana publikasi, serta pembinaan NSPK melalui pelayanan aplikasi dan non-aplikasi.</p></article></div>
                <div class="col-md-4"><article class="lawamena-info"><span class="info-icon"><i class="fa fa-network-wired"></i></span><h3>Peran</h3><p>Membangun jaringan informasi bagi pemerintah, pengembang, masyarakat, akademisi, dan pemangku kepentingan lainnya.</p></article></div>
            </div>
            <div class="alert alert-light border mt-3 mb-0 small text-secondary lh-lg"><strong class="text-dark">LAWAMENA MALUKU</strong> berperan sebagai pusat informasi dan layanan atas data maupun produk teknologi pembangunan perumahan dan kawasan permukiman, untuk pemerintah pusat/daerah, OPD terkait, asosiasi pengembang, masyarakat umum, serta kalangan akademisi.</div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center"><h2 class="dashboard-section-title mb-0"><i class="fa fa-star text-warning me-2"></i>Ulasan Terbaru</h2><a href="/console/ulasan-layanan" class="small fw-bold text-decoration-none">Kelola</a></div>
            @forelse($latestReviews as $review)
                <article class="review-quote"><div class="d-flex justify-content-between"><strong>{{ $review->name }}</strong><span class="text-warning">{{ str_repeat('★', $review->rating) }}</span></div><p>{{ $review->feedback ?: 'Masyarakat memberikan penilaian layanan.' }}</p></article>
            @empty
                <div class="dashboard-empty"><i class="fa fa-comment-slash fs-4 d-block mb-2"></i>Belum ada ulasan layanan.</div>
            @endforelse
        </div>
    </div>
</section>

@include('console.end')
