@extends('frontend.layouts.public')

@section('content')
@php
    $details = $rlthRecords->mapWithKeys(function ($record) {
        return [$record->id => [
            'name' => $record->name,
            'year' => $record->survey_year,
            'national_id' => $record->national_id ? str_repeat('*', max(0, strlen($record->national_id) - 4)).substr($record->national_id, -4) : null,
            'family_card_number' => $record->family_card_number ? str_repeat('*', max(0, strlen($record->family_card_number) - 4)).substr($record->family_card_number, -4) : null,
            'phone' => $record->phone ? str_repeat('*', max(0, strlen($record->phone) - 4)).substr($record->phone, -4) : null,
            'address' => $record->address,
            'village' => $record->village_name,
            'regency' => $record->regency_name,
            'occupation' => $record->occupation,
            'income' => $record->income_range,
            'house_ownership' => $record->house_ownership,
            'land_ownership' => $record->land_ownership,
            'other_assets' => $record->other_assets,
            'foundation' => $record->foundation_condition,
            'beam_column' => $record->beam_column_condition,
            'windows' => $record->window_availability,
            'ventilation' => $record->ventilation_availability,
            'mck' => $record->mck_availability,
            'water_source' => $record->water_source,
            'wall_type' => $record->wall_type,
            'roof_material' => $record->roof_material,
            'roof' => $record->roof_damage_level,
            'area' => $record->building_area,
            'latitude' => $record->latitude,
            'longitude' => $record->longitude,
            'photos' => array_filter([
                'Tampak depan' => $record->photoUrl('photo_front_path'),
                'Samping kiri' => $record->photoUrl('photo_left_path'),
                'Samping kanan' => $record->photoUrl('photo_right_path'),
                'Tampak belakang' => $record->photoUrl('photo_back_path'),
                'Atap bagian dalam' => $record->photoUrl('photo_roof_path'),
                'Jendela' => $record->photoUrl('photo_window_path'),
                'MCK' => $record->photoUrl('photo_mck_path'),
            ]),
        ]];
    })->all();
@endphp

<main class="rlth-page py-5">
    <div class="container">
        <section class="rlth-hero">
            <div>
                <small><i class="fas fa-clipboard-check me-2"></i>PENDATAAN RLTH</small>
                <h1>Pendataan Rumah Tidak Layak Huni</h1>
                <p>Informasi lokasi dan kondisi Rumah Tidak Layak Huni di Provinsi Maluku.</p>
            </div>
            <a href="#peta-rlth" class="btn btn-light fw-bold"><i class="fas fa-map-marked-alt me-2"></i>Lihat Peta</a>
        </section>

        <div class="row g-3 my-4">
            <div class="col-md-6"><article class="rlth-stat"><i class="fas fa-house-crack"></i><div><small>DATA RLTH TERCATAT</small><strong>{{ number_format($rlthTotal) }}</strong><span>rumah terdata</span></div></article></div>
            <div class="col-md-6"><article class="rlth-stat"><i class="fas fa-map-location-dot"></i><div><small>WILAYAH TERDATA</small><strong>{{ number_format($rlthRegencies) }}</strong><span>kabupaten/kota</span></div></article></div>
        </div>

        <form class="rlth-filter mb-4">
            <div class="row g-3">
                <div class="col-md-3"><label>Tahun</label><select name="tahun"><option value="">Semua Tahun</option>@foreach($rlthYears as $year)<option value="{{ $year }}" @selected(request('tahun') == $year)>{{ $year }}</option>@endforeach</select></div>
                <div class="col-md-3"><label>Kabupaten/Kota</label><select name="kabupaten"><option value="">Semua Kabupaten/Kota</option>@foreach($rlthRegencyOptions as $regency)<option value="{{ $regency }}" @selected(request('kabupaten') === $regency)>{{ $regency }}</option>@endforeach</select></div>
                <div class="col-md-2"><label>Desa</label><select name="desa"><option value="">Semua Desa</option>@foreach($rlthVillageOptions as $village)<option value="{{ $village }}" @selected(request('desa') === $village)>{{ $village }}</option>@endforeach</select></div>
                <div class="col-md-4"><label>Cari Data</label><input name="cari" value="" placeholder="Nama atau desa"></div>
            </div>
        </form>

        <div class="rlth-map-layout">
            <section id="peta-rlth" class="rlth-panel rlth-map-panel">
                <header><div><h2>Peta Sebaran RLTH</h2><p>Klik ikon rumah untuk melihat detail data.</p></div><span id="rlthMapCount">{{ $rlthRecords->whereNotNull('latitude')->whereNotNull('longitude')->count() }} titik lokasi</span></header>
                <div id="rlthMap"></div>
            </section>
            <section class="rlth-panel rlth-list-sidebar">
                <header><div><h2>Daftar Pendataan RLTH</h2><p><span id="rlthListCount">{{ $rlthRecords->count() }}</span> data sesuai filter.</p></div></header>
                <div class="rlth-list-scroll">
                    @forelse($rlthRecords as $record)
                        <article class="rlth-item" data-year="{{ $record->survey_year }}" data-regency="{{ Str::lower($record->regency_name) }}" data-village="{{ Str::lower($record->village_name) }}" data-search="{{ Str::lower($record->name.' '.$record->village_name.' '.$record->regency_name) }}">
                            @if($record->photo_front_path)<img class="rlth-item-photo" src="{{ $record->photoUrl('photo_front_path') }}" alt="Rumah {{ $record->name }}">@endif
                            <div class="rlth-item-body">
                                <span class="rlth-condition">{{ $record->roof_damage_level ?: 'Kondisi belum diisi' }}</span>
                                <div class="rlth-item-copy"><h3>{{ $record->name }}</h3><p><i class="fas fa-location-dot"></i>{{ $record->village_name ?: '-' }}, {{ $record->regency_name ?: '-' }}</p></div>
                                <button type="button" class="js-rlth-detail" data-id="{{ $record->id }}" aria-label="Lihat detail {{ $record->name }}" title="Lihat detail"><i class="fas fa-eye"></i></button>
                            </div>
                        </article>
                    @empty
                        <p class="text-center text-secondary py-4 mb-0">Belum ada data RLTH sesuai filter.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</main>

<div class="modal fade rlth-detail-modal" id="rlthDetailModal" tabindex="-1" aria-labelledby="rlthDetailTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><div><span class="modal-eyebrow"><i class="fas fa-house me-2"></i>DATA RLTH</span><h2 id="rlthDetailTitle">Detail Pendataan RLTH</h2></div><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
        <div class="modal-body" id="rlthDetailBody"></div>
    </div></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
.rlth-page{background:#f6fafc}.rlth-hero{display:flex;align-items:center;justify-content:space-between;gap:24px;padding:38px 44px;border-radius:22px;background:linear-gradient(120deg,#205e52,#23857a);color:#fff}.rlth-hero small,.modal-eyebrow{font-size:.75rem;font-weight:800;letter-spacing:.1em;color:#f7d999}.rlth-hero h1{margin:10px 0;font-size:clamp(1.65rem,3vw,2.45rem);font-weight:800}.rlth-hero p{margin:0;color:#e1f2ef}.rlth-stat{display:flex;align-items:center;gap:19px;padding:26px;border:1px solid #e1ebe7;border-radius:17px;background:#fff}.rlth-stat>i{display:grid;place-items:center;width:58px;height:58px;border-radius:16px;background:#e3f3ee;color:#1e7b6d;font-size:1.5rem}.rlth-stat small,.rlth-stat span,.rlth-stat strong{display:block}.rlth-stat small{font-size:.72rem;font-weight:800;color:#77858c}.rlth-stat strong{font-size:2rem;color:#214856}.rlth-stat span{font-size:.82rem;color:#77858c}.rlth-filter,.rlth-panel{border:1px solid #e0eae7;border-radius:18px;background:#fff}.rlth-filter{padding:20px}.rlth-filter label{display:block;margin-bottom:6px;color:#536a70;font-size:.78rem;font-weight:800}.rlth-filter select,.rlth-filter input{width:100%;height:42px;padding:0 11px;border:1px solid #d9e4e2;border-radius:9px;color:#40565d}.rlth-panel{overflow:hidden}.rlth-panel header{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 22px;border-bottom:1px solid #e7eeec}.rlth-panel h2{margin:0 0 4px;font-size:1.1rem;font-weight:800;color:#274756}.rlth-panel header p{margin:0;color:#708088;font-size:.82rem}.rlth-panel header>span{padding:6px 10px;border-radius:18px;background:#e5f4ef;color:#227363;font-size:.75rem;font-weight:800}.rlth-map-layout{display:grid;grid-template-columns:minmax(0,1.8fr) minmax(330px,.9fr);gap:18px;align-items:stretch}#rlthMap{height:650px}.rlth-list-sidebar{display:flex;height:714px}.rlth-list-scroll{flex:1;overflow-y:auto;padding:8px;background:linear-gradient(180deg,#f8fcfd,#f2f8f8);scrollbar-color:#ad8850 #eef3f2;scrollbar-width:thin}.rlth-list-scroll::-webkit-scrollbar{width:8px}.rlth-list-scroll::-webkit-scrollbar-thumb{border:2px solid #eef3f2;border-radius:10px;background:#ad8850}.rlth-item{display:flex;align-items:stretch;min-height:70px;margin-bottom:6px;border:1px solid #e0ecef;border-radius:11px;background:#fff;box-shadow:0 2px 7px #173e5409;transition:.18s}.rlth-item:hover{transform:translateX(-2px);border-color:#7eb6ae;box-shadow:0 7px 15px #173e541a}.rlth-item-photo{width:68px;flex:0 0 68px;object-fit:cover;border-radius:10px 0 0 10px}.rlth-item-body{position:relative;display:flex;align-items:center;gap:8px;min-width:0;flex:1;padding:9px 45px 9px 10px}.rlth-condition{flex:0 0 auto;max-width:76px;padding:4px 6px;border:1px solid #f1dfbd;border-radius:16px;background:#fff6e7;color:#956b1d;font-size:.61rem;font-weight:800;line-height:1.1}.rlth-item-copy{min-width:0}.rlth-item h3{display:-webkit-box;overflow:hidden;margin:0 0 3px;color:#294957;font-size:.82rem;font-weight:800;line-height:1.25;-webkit-box-orient:vertical;-webkit-line-clamp:2}.rlth-item p{display:-webkit-box;overflow:hidden;margin:0;color:#72838a;font-size:.7rem;line-height:1.3;-webkit-box-orient:vertical;-webkit-line-clamp:2}.rlth-item p i{color:#b38b49}.js-rlth-detail{position:absolute;right:9px;top:50%;display:grid;place-items:center;width:29px;height:29px;border:1px solid #b9d4d1;border-radius:8px;background:#fff;color:#1c756c;transform:translateY(-50%);transition:.18s}.js-rlth-detail:hover{border-color:#1c756c;background:#1c756c;color:#fff}.rlth-home-marker{display:grid;place-items:center;width:38px!important;height:38px!important;border:3px solid #fff;border-radius:50% 50% 50% 8px;background:linear-gradient(145deg,#1c8c79,#126358);box-shadow:0 4px 12px #163f4690;color:#fff;font-size:16px;transform:rotate(-45deg)}.rlth-home-marker i{transform:rotate(45deg)}.rlth-detail-modal .modal-content{overflow:hidden;border:0;border-radius:18px}.rlth-detail-modal .modal-header{align-items:flex-start;padding:22px 26px;border:0;background:linear-gradient(120deg,#164d45,#287b6d);color:#fff}.rlth-detail-modal h2{margin:5px 0 0;font-size:1.35rem;font-weight:800}.rlth-detail-modal .modal-body{padding:26px;background:#f7fbfa}.rlth-detail-heading{padding:20px 22px;margin-bottom:20px;border-radius:14px;background:#fff;border-left:5px solid #c5a05b;box-shadow:0 5px 18px #1834480b}.rlth-detail-heading h3{margin:0 0 5px;color:#244653;font-size:1.3rem;font-weight:800}.rlth-detail-heading p{margin:0;color:#6e8085}.rlth-detail-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}.rlth-detail-field{padding:14px 15px;border:1px solid #e2ece9;border-radius:11px;background:#fff}.rlth-detail-field small{display:block;margin-bottom:4px;color:#789097;font-size:.7rem;font-weight:800;text-transform:uppercase}.rlth-detail-field strong{color:#284854;font-size:.9rem}.rlth-detail-section-title{margin:24px 0 11px;color:#2c4c57;font-size:1rem;font-weight:800}.rlth-detail-photos{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}.rlth-detail-photo{overflow:hidden;border:1px solid #e0ebe8;border-radius:12px;background:#fff}.rlth-detail-photo small{display:block;padding:9px 11px;color:#526b70;font-weight:800}.rlth-detail-photo img{width:100%;height:160px;object-fit:cover}@media(max-width:991px){.rlth-map-layout{grid-template-columns:1fr}.rlth-list-sidebar{height:500px}#rlthMap{height:520px}}@media(max-width:576px){.rlth-hero{align-items:flex-start;padding:30px 25px;flex-direction:column}.rlth-detail-grid,.rlth-detail-photos{grid-template-columns:1fr}.rlth-item-body{gap:6px}.rlth-condition{max-width:68px}.rlth-detail-modal .modal-body{padding:18px}}
</style>
<style>.rlth-list-sidebar{flex-direction:column}.rlth-list-sidebar header{flex:0 0 auto}.rlth-list-scroll{min-height:0}.rlth-detail-group{margin:0 0 18px}.rlth-detail-group h4{display:flex;align-items:center;gap:9px;margin:0 0 10px;color:#28515b;font-size:.92rem;font-weight:850}.rlth-detail-group h4 i{display:grid;place-items:center;width:29px;height:29px;border-radius:8px;background:#e7f3ef;color:#177467;font-size:.76rem}.rlth-detail-group .rlth-detail-grid{padding:12px;border:1px solid #e4edeb;border-radius:13px;background:#fbfdfc}.rlth-detail-group .rlth-detail-field{border-color:#e8efed;box-shadow:none}.rlth-detail-group .rlth-detail-field:first-child:nth-last-child(odd){grid-column:auto}</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const records = @json($details);
    const items = @json($rlthMapItems);
    const escapeHtml = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[char]));
    const modalElement = document.querySelector('#rlthDetailModal');
    const modal = window.bootstrap ? bootstrap.Modal.getOrCreateInstance(modalElement) : null;
    const showDetail = record => {
        if (!record || !modal) return;
        const value = value => value ? escapeHtml(value) : '-';
        const field = ([label, item]) => `<div class="rlth-detail-field"><small>${label}</small><strong>${value(item)}</strong></div>`;
        const group = (title, icon, fields) => `<section class="rlth-detail-group"><h4><i class="fas ${icon}"></i>${title}</h4><div class="rlth-detail-grid">${fields.map(field).join('')}</div></section>`;
        const fieldHtml = group('Identitas Pendataan', 'fa-id-card', [
            ['Tahun pendataan',record.year], ['NIK',record.national_id], ['Nomor KK',record.family_card_number], ['Nomor telepon',record.phone],
        ]) + group('Alamat dan Koordinat', 'fa-map-location-dot', [
            ['Alamat',record.address], ['Desa / Kelurahan',record.village], ['Kabupaten / Kota',record.regency], ['Koordinat',record.latitude && record.longitude ? `${record.latitude}, ${record.longitude}` : null],
        ]) + group('Sosial dan Kepemilikan', 'fa-people-roof', [
            ['Pekerjaan',record.occupation], ['Penghasilan',record.income], ['Status rumah',record.house_ownership], ['Status tanah',record.land_ownership], ['Aset lainnya',record.other_assets],
        ]) + group('Kondisi Bangunan', 'fa-house-chimney-crack', [
            ['Kondisi pondasi',record.foundation], ['Balok / kolom',record.beam_column], ['Dinding',record.wall_type], ['Atap',record.roof_material], ['Tingkat kerusakan atap',record.roof], ['Luas bangunan',record.area ? `${record.area} m²` : null], ['Jendela',record.windows], ['Ventilasi',record.ventilation], ['MCK',record.mck], ['Sumber air bersih',record.water_source],
        ]);
        const photos = Object.entries(record.photos || {}).map(([label,url]) => `<a class="rlth-detail-photo" href="${escapeHtml(url)}" target="_blank" rel="noopener"><small>${escapeHtml(label)}</small><img src="${escapeHtml(url)}" alt="${escapeHtml(label)} - ${escapeHtml(record.name)}"></a>`).join('') || '<p class="text-secondary mb-0">Belum ada dokumentasi foto untuk data ini.</p>';
        document.querySelector('#rlthDetailBody').innerHTML = `<section class="rlth-detail-heading"><h3>${value(record.name)}</h3><p><i class="fas fa-location-dot me-2"></i>${value([record.village,record.regency].filter(Boolean).join(', '))}</p></section>${fieldHtml}<h4 class="rlth-detail-section-title"><i class="fas fa-images me-2"></i>Dokumentasi Rumah</h4><div class="rlth-detail-photos">${photos}</div>`;
        modal.show();
    };
    document.querySelectorAll('.js-rlth-detail').forEach(button => button.addEventListener('click', () => showDetail(records[button.dataset.id])));

    const form = document.querySelector('.rlth-filter');
    const listItems = [...document.querySelectorAll('.rlth-item')];
    const listCount = document.querySelector('#rlthListCount');
    const mapCount = document.querySelector('#rlthMapCount');

    if (!window.L) return;
    const homeIcon = L.divIcon({className:'rlth-home-marker',html:'<i class="fas fa-house"></i>',iconSize:[38,38],iconAnchor:[19,34],popupAnchor:[0,-32]});
    const map = L.map('rlthMap').setView([-3.7,128.2], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap',maxZoom:19}).addTo(map);
    const markers = [];
    items.forEach(item => { const marker = L.marker([item.lat,item.lng],{icon:homeIcon}).bindTooltip(escapeHtml(item.name),{direction:'top'}); marker.on('click', () => showDetail(item.detail)); markers.push({ marker, item }); marker.addTo(map); });
    if (markers.length) map.fitBounds(L.featureGroup(markers.map(({ marker }) => marker)).getBounds().pad(.15));

    const applyFilter = () => {
        const year = form.elements.tahun.value;
        const regency = form.elements.kabupaten.value.toLocaleLowerCase();
        const village = form.elements.desa.value.toLocaleLowerCase();
        const search = form.elements.cari.value.trim().toLocaleLowerCase();
        const matches = item => (!year || item.dataset.year === year) && (!regency || item.dataset.regency === regency) && (!village || item.dataset.village === village) && (!search || item.dataset.search.includes(search));
        const visibleIds = new Set();
        let visibleCount = 0;
        listItems.forEach(item => { const visible = matches(item); item.hidden = !visible; if (visible) { visibleCount++; visibleIds.add(Number(item.querySelector('.js-rlth-detail').dataset.id)); } });
        let visibleMarkers = 0;
        markers.forEach(({ marker, item }) => { const visible = visibleIds.has(Number(item.id)); if (visible) { marker.addTo(map); visibleMarkers++; } else { marker.remove(); } });
        listCount.textContent = visibleCount;
        mapCount.textContent = `${visibleMarkers} titik lokasi`;
    };
    form?.querySelectorAll('select').forEach(select => select.addEventListener('change', applyFilter));
    form?.querySelector('input[name="cari"]')?.addEventListener('input', applyFilter);
});
</script>
@endsection
