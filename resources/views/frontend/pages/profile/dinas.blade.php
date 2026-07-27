@extends('frontend.layouts.public')

@section('content')
<style>
    .dinas-profile-page{padding:42px 0 76px;background:linear-gradient(180deg,#f0f8fa 0,#fff 48%,#f8fbfc 100%)}
    .dinas-hero{position:relative;overflow:hidden;padding:42px;border-radius:24px;background:linear-gradient(125deg,#153b50,#22667d 65%,#7da7b4);box-shadow:0 18px 42px #173c501f;color:#fff}
    .dinas-hero:after{position:absolute;width:290px;height:290px;top:-145px;right:-65px;border:1px solid #ffffff2e;border-radius:50%;box-shadow:0 0 0 33px #ffffff0c,0 0 0 66px #ffffff08;content:''}
    .dinas-hero-inner{position:relative;z-index:1;display:flex;align-items:center;gap:25px}
    .dinas-emblem{display:grid;flex:0 0 95px;width:95px;height:95px;place-items:center;border:5px solid #ffffff4d;border-radius:24px;background:#fff;box-shadow:0 10px 25px #102a3a40}
    .dinas-emblem img{max-width:70px;max-height:70px;object-fit:contain}
    .dinas-overline{margin:0 0 7px;color:#f5d993;font-size:.74rem;font-weight:900;letter-spacing:.15em}
    .dinas-hero h1{max-width:760px;margin:0;font-size:2rem;font-weight:900;line-height:1.18;letter-spacing:-.025em}
    .dinas-hero p{margin:10px 0 0;color:#d9ebf0;font-size:.95rem}
    .dinas-grid{display:grid;grid-template-columns:minmax(0,1.45fr) minmax(285px,.7fr);gap:25px;margin-top:25px}
    .dinas-card{border:1px solid #dcebef;border-radius:19px;background:#fff;box-shadow:0 10px 27px #173f5110}
    .dinas-card-body{padding:30px}
    .dinas-section-title{display:flex;align-items:center;gap:10px;margin:0 0 16px;color:#22475b;font-size:1.18rem;font-weight:900}
    .dinas-section-title i{display:grid;width:35px;height:35px;place-items:center;border-radius:10px;background:#e3f1f4;color:#1d7793;font-size:.94rem}
    .dinas-copy{color:#516872;font-size:.94rem;line-height:1.85;white-space:pre-line}
    .dinas-copy p:first-child{margin-top:0}.dinas-copy p:last-child{margin-bottom:0}
    .dinas-contact-card{padding:27px;background:linear-gradient(160deg,#fdfefe,#edf7f8)}
    .dinas-contact-card h2{margin:0 0 19px;color:#25495b;font-size:1.03rem;font-weight:900}
    .dinas-contact-item{display:flex;gap:12px;padding:13px 0;border-bottom:1px solid #dcebed}.dinas-contact-item:last-child{border-bottom:0}
    .dinas-contact-item i{display:grid;flex:0 0 34px;width:34px;height:34px;place-items:center;border-radius:10px;background:#dceff3;color:#1d7190}
    .dinas-contact-item small{display:block;margin-bottom:2px;color:#80959e;font-size:.65rem;font-weight:900;letter-spacing:.07em}.dinas-contact-item span,.dinas-contact-item a{color:#46616d;font-size:.8rem;font-weight:700;line-height:1.45;text-decoration:none}
    .dinas-direction{margin-top:25px;padding:28px 30px;border:1px solid #d9e9ed;border-left:5px solid #c6a260;border-radius:18px;background:linear-gradient(115deg,#fffdf8,#f4faf9);box-shadow:0 8px 22px #173f510d}
    .dinas-direction h2{margin:0 0 10px;color:#2a4a59;font-size:1.08rem;font-weight:900}.dinas-direction p{margin:0;color:#57707b;line-height:1.75;white-space:pre-line}
    .dinas-history{margin-top:25px;padding:31px;border:1px solid #dcebef;border-radius:19px;background:#fff;box-shadow:0 10px 27px #173f5110}
    .dinas-history-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:20px}.dinas-history-item{position:relative;padding:18px;border:1px solid #e1edf0;border-radius:14px;background:#fbfdfd}.dinas-history-item:before{position:absolute;width:10px;height:10px;top:-6px;left:18px;border-radius:50%;background:#c6a260;box-shadow:0 0 0 4px #fff8e8;content:''}.dinas-history-item h3{margin:0 0 7px;color:#31566a;font-size:.9rem;font-weight:900}.dinas-history-item p{margin:0;color:#70858e;font-size:.79rem;line-height:1.6}
    .dinas-services{display:grid;grid-template-columns:repeat(5,1fr);gap:13px;margin-top:20px}.dinas-service{padding:17px 12px;border:1px solid #dfecef;border-radius:14px;background:#fff;text-align:center;transition:.2s}.dinas-service:hover{transform:translateY(-4px);border-color:#a9d0dc;box-shadow:0 12px 22px #1a52641a}.dinas-service i{display:grid;width:39px;height:39px;margin:0 auto 10px;place-items:center;border-radius:11px;background:#e7f4f6;color:#207a95}.dinas-service span{display:block;color:#42616f;font-size:.74rem;font-weight:900;line-height:1.35}
    @media(max-width:991px){.dinas-grid{grid-template-columns:1fr}.dinas-services{grid-template-columns:repeat(3,1fr)}}
    @media(max-width:576px){.dinas-profile-page{padding:25px 0 52px}.dinas-hero{padding:27px 22px}.dinas-hero-inner{align-items:flex-start;gap:15px}.dinas-emblem{flex-basis:62px;width:62px;height:62px;border-radius:17px}.dinas-emblem img{max-width:44px;max-height:44px}.dinas-hero h1{font-size:1.38rem}.dinas-card-body,.dinas-history{padding:22px}.dinas-history-grid{grid-template-columns:1fr}.dinas-services{grid-template-columns:repeat(2,1fr)}}
</style>

<main class="dinas-profile-page">
    <div class="container">
        <section class="dinas-hero">
            <div class="dinas-hero-inner">
                <div class="dinas-emblem"><img src="{{ $setting?->logo_path ? asset('storage/'.$setting->logo_path) : asset('assets/img/logo.png') }}" alt="Logo Dinas PKP Maluku"></div>
                <div><p class="dinas-overline">PROFIL ORGANISASI</p><h1>{{ strtoupper($setting?->agency_name ?? 'DINAS PERUMAHAN DAN KAWASAN PEMUKIMAN') }}</h1><p>Provinsi Maluku · Melayani pembangunan perumahan dan kawasan permukiman yang layak, aman, dan berkelanjutan.</p></div>
            </div>
        </section>

        <div class="dinas-grid">
            <article class="dinas-card"><div class="dinas-card-body"><h2 class="dinas-section-title"><i class="fas fa-building"></i>Tentang Dinas</h2><div class="dinas-copy">{{ $setting?->about ?: 'Informasi profil dinas belum diperbarui.' }}</div></div></article>
            <aside class="dinas-card dinas-contact-card"><h2><i class="fas fa-address-card text-primary me-2"></i>Informasi Kontak</h2><div class="dinas-contact-item"><i class="fas fa-location-dot"></i><div><small>ALAMAT KANTOR</small><span>{{ $setting?->address ?: 'Alamat kantor belum diisi' }}</span></div></div><div class="dinas-contact-item"><i class="fas fa-envelope"></i><div><small>EMAIL</small><a href="mailto:{{ $setting?->email }}">{{ $setting?->email ?: 'Email belum diisi' }}</a></div></div><div class="dinas-contact-item"><i class="fas fa-phone"></i><div><small>TELEPON</small><span>{{ $setting?->phone ?: 'Nomor telepon belum diisi' }}</span></div></div></aside>
        </div>

        <section class="dinas-history"><h2 class="dinas-section-title"><i class="fas fa-clock-rotate-left"></i>Sejarah Singkat Dinas</h2><div class="dinas-copy">{{ $setting?->history ?: 'Sejarah dinas belum diperbarui.' }}</div><div class="dinas-history-grid"><article class="dinas-history-item"><h3>Pembentukan Dinas</h3><p>Perangkat daerah yang melaksanakan urusan pemerintahan bidang perumahan rakyat dan kawasan permukiman.</p></article><article class="dinas-history-item"><h3>Pengembangan Layanan</h3><p>Peningkatan pelayanan perumahan, penanganan kawasan, dan dukungan bagi masyarakat berpenghasilan rendah.</p></article><article class="dinas-history-item"><h3>Transformasi Pelayanan</h3><p>Penguatan program strategis dan informasi terpadu bagi pembangunan permukiman berkelanjutan.</p></article></div></section>

        <section class="dinas-direction"><h2><i class="fas fa-compass me-2 text-warning"></i>Arah Pelayanan Dinas</h2><p>{{ $setting?->mission ?: 'Meningkatkan kualitas pelayanan, penyediaan perumahan, dan pembangunan kawasan permukiman secara berkelanjutan.' }}</p></section>



        <section class="dinas-history"><h2 class="dinas-section-title"><i class="fas fa-handshake-angle"></i>Ruang Lingkup Layanan</h2><div class="dinas-services"><div class="dinas-service"><i class="fas fa-map-location-dot"></i><span>Perencanaan Permukiman</span></div><div class="dinas-service"><i class="fas fa-house-chimney"></i><span>Pembangunan Perumahan</span></div><div class="dinas-service"><i class="fas fa-city"></i><span>Penataan Kawasan</span></div><div class="dinas-service"><i class="fas fa-money-bill-wave"></i><span>Pembiayaan Perumahan</span></div><div class="dinas-service"><i class="fas fa-clipboard-check"></i><span>Pengawasan Pembangunan</span></div></div></section>
    </div>
</main>
@php
    $profileData = [
        'tagline' => $setting?->profile_tagline,
        'direction' => $setting?->profile_direction ?: $setting?->mission,
        'milestones' => $setting?->profile_milestones,
        'services' => $setting?->service_scopes,
    ];
@endphp
<script>
    (() => {
        const profile = @json($profileData);
        const heroText = document.querySelector('.dinas-hero p:not(.dinas-overline)');
        if (profile.tagline && heroText) heroText.textContent = profile.tagline;
        const direction = document.querySelector('.dinas-direction p');
        if (profile.direction && direction) direction.textContent = profile.direction;
        document.querySelector('.dinas-history-grid')?.remove();
        document.querySelector('.dinas-services')?.closest('.dinas-history')?.remove();
        const makeItem = (className, title, description) => {
            const item = document.createElement('article'); item.className = className;
            const heading = document.createElement('h3'); heading.textContent = title;
            const text = document.createElement('p'); text.textContent = description;
            item.append(heading, text); return item;
        };
        if (Array.isArray(profile.milestones) && profile.milestones.length) {
            const grid = document.querySelector('.dinas-history-grid');
            if (grid) { grid.replaceChildren(); profile.milestones.forEach(item => grid.append(makeItem('dinas-history-item', item.title || 'Tahapan Layanan', item.description || ''))); }
        }
        if (Array.isArray(profile.services) && profile.services.length) {
            const icons = ['fa-map-location-dot','fa-house-chimney','fa-city','fa-money-bill-wave','fa-clipboard-check','fa-people-roof'];
            const grid = document.querySelector('.dinas-services');
            if (grid) { grid.replaceChildren(); profile.services.forEach((service, index) => { const item = document.createElement('div'); item.className = 'dinas-service'; const icon = document.createElement('i'); icon.className = `fas ${icons[index % icons.length]}`; const label = document.createElement('span'); label.textContent = service; item.append(icon, label); grid.append(item); }); }
        }
    })();
</script>
@endsection
