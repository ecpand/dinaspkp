@extends('frontend.layouts.public')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
    .geomap-page { padding: 38px 0 70px; background: linear-gradient(180deg, #eff8fa 0, #fff 68%); }
    .geomap-title { margin: 0; color: #193f54; font-size: 2rem; font-weight: 900; letter-spacing: -.03em; }
    .geomap-intro { margin: 8px 0 22px; color: #71828b; }
    .geomap-shell { display: grid; grid-template-columns: minmax(0, 1fr) 355px; overflow: hidden; border: 1px solid #d5e6ea; border-radius: 20px; background: #fff; box-shadow: 0 15px 36px #173e5420; }
    .geomap-toolbar { display: flex; flex-wrap: wrap; gap: 10px; padding: 16px; border-bottom: 1px solid #dfebee; background: #fff; }
    .geomap-toolbar .form-select { width: auto; min-width: 156px; border-color: #cbdde3; border-radius: 9px; font-size: .84rem; }
    .geomap-toolbar .form-control { max-width: 220px; border-color: #cbdde3; border-radius: 9px; font-size: .84rem; }
    .area-color-chip { display:none; align-items:center; gap:6px; padding:0 10px; border:1px solid #d7e6ea; border-radius:9px; color:#55717e; background:#f8fbfc; font-size:.74rem; font-weight:800; white-space:nowrap; }
    .area-color-chip.show { display:flex; }
    .area-color-dot { width:12px; height:12px; border:2px solid #fff; border-radius:50%; box-shadow:0 0 0 1px #9db3bc; }
    .geomap-canvas { height: 650px; }
    .map-legend { display: flex; flex-wrap: wrap; gap: 12px; padding: 12px 16px; border-top: 1px solid #dfebee; color: #607983; font-size: .74rem; }
    .map-legend i { margin-right: 4px; }
    .geomap-side { max-height: 714px; overflow: auto; border-left: 1px solid #dfebee; background: #f9fcfd; }
    .side-heading { position: sticky; top: 0; z-index: 4; padding: 17px; background: #193f54; color: #fff; box-shadow: 0 3px 12px #102e4022; }
    .side-heading h2 { margin: 0; font-size: 1rem; font-weight: 900; }
    .side-count { display: inline-block; margin-top: 8px; padding: 4px 9px; border-radius: 16px; background: #ffffff24; font-size: .73rem; font-weight: 800; }
    .map-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 9px; padding: 14px; }
    .map-stat { padding: 10px; border: 1px solid #e0ecef; border-radius: 11px; background: #fff; }
    .map-stat strong { display: block; color: #1c5e90; font-size: 1.05rem; }
    .map-stat small { color: #758991; font-size: .64rem; font-weight: 800; }
    .recipient-tree { padding: 0 14px 18px; }
    .tree-group { margin-bottom: 9px; border: 1px solid #dce9ed; border-radius: 10px; background: #fff; overflow: hidden; }
    .tree-group summary { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 10px 11px; cursor: pointer; color: #274c60; font-size: .78rem; font-weight: 900; list-style: none; }
    .tree-group summary::-webkit-details-marker { display: none; }
    .tree-group summary:before { content: '\f107'; font-family: 'Font Awesome 5 Free'; font-weight: 900; color: #1c78bd; transition: .2s; }
    .tree-group:not([open]) summary:before { transform: rotate(-90deg); }
    .tree-badge { min-width: 22px; padding: 2px 6px; border-radius: 10px; background: #eaf4fa; color: #21628c; text-align: center; font-size: .67rem; }
    .tree-years { padding: 0 10px 10px; }
    .tree-year { margin-top: 6px; border-left: 3px solid #3f90c2; background: #f5fafc; }
    .tree-year summary { padding: 8px 9px; font-size: .72rem; }
    .tree-village { margin: 4px 8px 0; border: 0; border-bottom: 1px dashed #d8e5e8; border-radius: 0; }
    .tree-village:last-child { border-bottom: 0; }
    .tree-village summary { padding: 7px 1px; color: #607983; font-size: .7rem; }
    .recipient-button { display: block; width: calc(100% - 14px); margin: 0 7px 6px; padding: 8px; border: 0; border-radius: 7px; background: #fff; color: #426171; text-align: left; font-size: .71rem; line-height: 1.35; transition: .15s; }
    .recipient-button:hover { background: #e6f4fc; color: #1266a0; }
    .recipient-button b { display: block; color: inherit; }
    .recipient-button span { color: #7a929d; font-size: .65rem; }
    .map-empty { padding: 25px 10px; color: #7b919b; text-align: center; font-size: .8rem; }
    .recipient-id-icon { background: transparent!important; border: 0!important; }
    .recipient-id-marker { display:grid; width:32px; height:32px; place-items:center; border:2px solid #fff; border-radius:50%; background:var(--marker-color,#1768bf); box-shadow:0 2px 7px #17364788,0 0 0 1px #17364744; color:#fff; font-size:10px; font-weight:900; line-height:1; }
    .recipient-id-marker:hover { transform:scale(1.13); box-shadow:0 3px 10px #173647a8,0 0 0 2px #fff; }
    .leaflet-popup-content { min-width: 210px; }
    .geo-popup-title { color: #1b455b; font-weight: 900; }
    .geo-popup-meta { margin-top: 5px; color: #687f89; font-size: 12px; }
    .geo-popup-link { display: inline-block; margin-top: 8px; color: #176cc1; font-size: 12px; font-weight: 800; cursor: pointer; }
    .recipient-dialog { position: fixed; inset: 0; z-index: 2000; display: none; align-items: center; justify-content: center; padding: 18px; background: #0e263a99; }
    .recipient-dialog.show { display: flex; }
    .dialog-card { position: relative; width: min(660px, 100%); max-height: calc(100vh - 36px); overflow: auto; border-radius: 18px; background: #fff; box-shadow: 0 24px 70px #06131f80; }
    .dialog-close { position: absolute; top: 12px; right: 12px; z-index: 1; width: 34px; height: 34px; border: 0; border-radius: 50%; background: #edf4f6; color: #345568; font-size: 1.1rem; }
    .dialog-top { padding: 25px 54px 22px 25px; background: linear-gradient(135deg, #1a4961, #267db2); color: #fff; }
    .dialog-top h3 { margin: 0 0 5px; font-size: 1.32rem; font-weight: 900; }
    .dialog-top p { margin: 0; color: #dceefa; font-size: .84rem; }
    .dialog-body { padding: 23px 25px 27px; }
    .dialog-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 11px; margin-bottom: 17px; }
    .dialog-field { padding: 10px; border: 1px solid #e0ebee; border-radius: 9px; background: #fafdfd; }
    .dialog-field label { display: block; margin-bottom: 3px; color: #79919b; font-size: .65rem; font-weight: 900; text-transform: uppercase; }
    .dialog-field span { color: #304d5d; font-size: .82rem; font-weight: 700; }
    .progress-box { margin: 4px 0 20px; }
    .progress-line { height: 8px; overflow: hidden; border-radius: 10px; background: #e3edf0; }
    .progress-line i { display: block; height: 100%; border-radius: inherit; background: linear-gradient(90deg, #1d78be, #40a1db); }
    .photos-title { margin: 0 0 9px; color: #315467; font-size: .88rem; font-weight: 900; }
    .photo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 11px; }
    .photo-box { overflow: hidden; border: 1px solid #e0ebee; border-radius: 10px; background: #f7fbfc; }
    .photo-box small { display: block; padding: 7px 9px; color: #627f8e; font-weight: 800; }
    .photo-box img { display: block; width: 100%; height: 135px; object-fit: cover; }
    .no-photo { display: grid; height: 135px; place-items: center; color: #96aab3; font-size: .8rem; font-style: italic; }
    @media (max-width: 991px) { .geomap-shell { grid-template-columns: 1fr; } .geomap-side { max-height: 420px; border-top: 1px solid #dfebee; border-left: 0; } .geomap-canvas { height: 520px; } }
    @media (max-width: 576px) { .geomap-toolbar .form-select, .geomap-toolbar .form-control { width: 100%; max-width: none; } .geomap-title { font-size: 1.55rem; } .dialog-grid, .photo-grid { grid-template-columns: 1fr; } }
</style>

<main class="geomap-page">
    <div class="container">
        <header>
            <h1 class="geomap-title"><i class="fas fa-map-marked-alt me-2 text-primary"></i>SIGAProgram PKP Provinsi Maluku</h1>
            <p class="geomap-intro">System Informasi Geospasial Program Perumahan Dan Kawasan Permukiman.</p>
        </header>
        <section class="geomap-shell">
            <div>
                <div class="geomap-toolbar">
                    <select id="regency" class="form-select" aria-label="Filter kabupaten atau kota"><option value="">Filter Kabupaten / Kota</option>@foreach($regencies as $regency)<option value="{{ $regency->id }}">{{ str_contains(strtolower($regency->name), 'aru') ? 'Kabupaten ' : '' }}{{ $regency->name }}</option>@endforeach</select>
                    <select id="village" class="form-select"><option value="">Semua Desa</option>@foreach($villages as $village)<option value="{{ $village->id }}" data-regency="{{ $village->regency_id }}">{{ $village->name }}</option>@endforeach</select>
                    <select id="programType" class="form-select"><option value="">Semua Program</option>@foreach($programTypes as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach</select>
                    @php($areaGroups = $mapAreas->groupBy(fn ($area) => str_contains($area->name, ' — ') ? explode(' — ', $area->name, 2)[0] : 'Kabupaten / Kota'))
                    <select id="area" class="form-select" aria-label="Filter wilayah GeoJSON" disabled>
                        <option value="">Pilih Kabupaten terlebih dahulu</option>
                        @foreach($areaGroups as $groupName => $groupAreas)
                            <optgroup label="{{ $groupName }} ({{ $groupAreas->count() }})">
                                @if($groupName !== 'Kabupaten / Kota' && $groupAreas->count() > 1)
                                    @php($groupRegencyIds = $groupAreas->pluck('regency_id')->filter()->unique())
                                    <option value="group:{{ $groupName }}" data-group="{{ $groupName }}" data-regency="{{ $groupRegencyIds->count() === 1 ? $groupRegencyIds->first() : '' }}">Semua {{ $groupName }}</option>
                                @endif
                                @foreach($groupAreas as $area)
                                    @php($areaLabel = str_contains($area->name, ' — ') ? explode(' — ', $area->name, 2)[1] : $area->name)
                                    <option value="{{ $area->id }}" data-regency="{{ $area->regency_id }}" data-village="{{ $area->village_id }}" data-color="{{ $area->color ?: '#2563eb' }}">{{ $areaLabel }}{{ $area->regency ? ' — '.$area->regency->name : '' }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <span id="areaColorChip" class="area-color-chip"><i class="area-color-dot"></i><span>Warna wilayah</span></span>
                    <select id="baseLayer" class="form-select"><option value="default">Peta Default</option><option value="terrain">Terrain</option><option value="satellite">Satelit</option><option value="hybrid">Hybrid</option></select>
                    <input id="searchMap" class="form-control" placeholder="Cari penerima atau desa...">
                    <button id="downloadData" class="btn btn-outline-primary btn-sm"><i class="fas fa-download me-1"></i>CSV</button>
                </div>
                <div id="mbbrMap" class="geomap-canvas"></div>
                <div class="map-legend"><span><i class="fas fa-circle" style="color:#2166c2"></i>Pembangunan Perumahan</span><span><i class="fas fa-circle" style="color:#099579"></i>Kawasan Permukiman</span><span><i class="fas fa-circle" style="color:#7d4edb"></i>Peningkatan PSU</span><span><i class="fas fa-square" style="color:#ee7a34"></i>Wilayah / Kawasan</span></div>
            </div>
            <aside class="geomap-side">
                <div class="side-heading"><h2><i class="fas fa-layer-group me-2"></i>DAFTAR DATA PENERIMA</h2><span id="totalCount" class="side-count">Memuat data...</span></div>
                <div class="map-stats"><div class="map-stat"><strong id="statTotal">0</strong><small>TOTAL PENERIMA</small></div><div class="map-stat"><strong id="statDone">0</strong><small>SELESAI</small></div><div class="map-stat"><strong id="statProcess">0</strong><small>PROSES</small></div><div class="map-stat"><strong id="statWaiting">0</strong><small>MENUNGGU</small></div></div>
                <div id="recipientTree" class="recipient-tree"></div>
            </aside>
        </section>
    </div>
</main>

<div id="recipientDialog" class="recipient-dialog" aria-hidden="true"><section class="dialog-card" role="dialog" aria-modal="true" aria-label="Detail penerima"><button id="dialogClose" class="dialog-close" aria-label="Tutup">&times;</button><div id="dialogContent"></div></section></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('mbbrMap').setView([-3.7, 128.1], 7);
    const tileUrls = { default: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', terrain: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', satellite: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', hybrid: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}' };
    let baseLayer = L.tileLayer(tileUrls.default, { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);
    let recipientLayer, areaLayer, allPoints = [], pointMarkers = {};
    const programColors = { 1: '#2166c2', 2: '#099579', 3: '#7d4edb' };
    const byId = id => document.getElementById(id);
    const esc = value => String(value ?? '-').replace(/[&<>'"]/g, char => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;' }[char]));
    const money = value => value ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value) : '-';

    function detailDialog(p) {
        const progress = Math.max(0, Math.min(100, Number(p.progress || 0)));
        const photo = (label, url) => `<div class="photo-box"><small>${label}</small>${url ? `<a href="${esc(url)}" target="_blank"><img src="${esc(url)}" alt="${label}"></a>` : '<div class="no-photo">No Foto</div>'}</div>`;
        byId('dialogContent').innerHTML = `<div class="dialog-top"><h3>${esc(p.name)}</h3><p>${esc(p.program_type)} &bull; ${esc(p.year || '-')}</p></div><div class="dialog-body"><div class="dialog-grid"><div class="dialog-field"><label>Program</label><span>${esc(p.program)}</span></div><div class="dialog-field"><label>Status</label><span>${esc(p.status)}</span></div><div class="dialog-field"><label>Lokasi</label><span>${esc(p.village)}, ${esc(p.regency)}</span></div><div class="dialog-field"><label>Pelaksana</label><span>${esc(p.provider)}</span></div><div class="dialog-field"><label>Kondisi Rumah</label><span>${esc(p.condition)}</span></div><div class="dialog-field"><label>Decile</label><span>${esc(p.decile)}</span></div><div class="dialog-field"><label>Bantuan Material</label><span>${money(p.material_cost)}</span></div><div class="dialog-field"><label>Bantuan Upah</label><span>${money(p.labor_cost)}</span></div></div><div class="progress-box"><div class="d-flex justify-content-between mb-1"><strong class="small">Progres Pekerjaan</strong><strong class="small text-primary">${progress}%</strong></div><div class="progress-line"><i style="width:${progress}%"></i></div></div><h4 class="photos-title">Dokumentasi Penerima</h4><div class="photo-grid">${photo('Foto Awal', p.photo_initial)}${photo('Foto Progres', p.photo_progress)}</div></div>`;
        byId('recipientDialog').classList.add('show');
        byId('recipientDialog').setAttribute('aria-hidden', 'false');
    }
    function closeDialog() { byId('recipientDialog').classList.remove('show'); byId('recipientDialog').setAttribute('aria-hidden', 'true'); }
    byId('dialogClose').onclick = closeDialog;
    byId('recipientDialog').onclick = event => { if (event.target === byId('recipientDialog')) closeDialog(); };

    function pointPopup(p) { return `<div class="geo-popup-title">${esc(p.name)}</div><div class="geo-popup-meta"><b>${esc(p.program_type)}</b><br>${esc(p.village)}, ${esc(p.regency)}<br>Status: ${esc(p.status)} &bull; Progres: ${esc(p.progress)}%</div><button class="geo-popup-link" onclick="openRecipientDetail(${Number(p.id)})">Lihat detail penerima <i class="fas fa-arrow-right"></i></button>`; }
    window.openRecipientDetail = id => { const feature = allPoints.find(item => Number(item.properties.id) === Number(id)); if (feature) detailDialog(feature.properties); };

    function renderTree() {
        const term = byId('searchMap').value.trim().toLowerCase();
        const filtered = allPoints.filter(feature => [feature.properties.name, feature.properties.village, feature.properties.regency, feature.properties.program_type].join(' ').toLowerCase().includes(term));
        const tree = {};
        filtered.forEach(feature => {
            const p = feature.properties, type = p.program_type || 'Program Lainnya', year = p.year || 'Tanpa Tahun', village = p.village || 'Tanpa Desa';
            tree[type] ||= {}; tree[type][year] ||= {}; tree[type][year][village] ||= []; tree[type][year][village].push(p);
        });
        const treeHtml = Object.entries(tree).map(([type, years]) => {
            const typeTotal = Object.values(years).flatMap(villages => Object.values(villages)).flat().length;
            return `<details class="tree-group" open><summary><span>${esc(type)}</span><b class="tree-badge">${typeTotal}</b></summary><div class="tree-years">${Object.entries(years).map(([year, villages]) => `<details class="tree-group tree-year" open><summary><span>Tahun ${esc(year)}</span><b class="tree-badge">${Object.values(villages).flat().length}</b></summary>${Object.entries(villages).map(([village, recipients]) => `<details class="tree-group tree-village" open><summary><span>${esc(village)}</span><b class="tree-badge">${recipients.length}</b></summary>${recipients.map(p => `<button class="recipient-button" data-recipient="${Number(p.id)}"><b>${esc(p.name)}</b><span>${esc(p.regency)} &bull; ${esc(p.status)}</span></button>`).join('')}</details>`).join('')}</details>`).join('')}</div></details>`;
        }).join('');
        byId('recipientTree').innerHTML = treeHtml || '<div class="map-empty">Data penerima tidak ditemukan.</div>';
        document.querySelectorAll('.recipient-button').forEach(button => button.onclick = () => {
            const id = Number(button.dataset.recipient), marker = pointMarkers[id];
            if (marker) { map.setView(marker.getLatLng(), 15); marker.openPopup(); }
            window.openRecipientDetail(id);
        });
    }

    function drawMap(data) {
        if (recipientLayer) map.removeLayer(recipientLayer);
        if (areaLayer) map.removeLayer(areaLayer);
        allPoints = data.features.filter(feature => feature.properties.feature_type === 'recipient');
        const areas = data.features.filter(feature => feature.properties.feature_type === 'area');
        pointMarkers = {};
        areaLayer = L.geoJSON({ type: 'FeatureCollection', features: areas }, {
            style: feature => ({ color: feature.properties.color || '#e6792f', fillColor: feature.properties.color || '#e6792f', weight: feature.properties.category === 'Kawasan Kumuh' ? 2.4 : 1.5, fillOpacity: feature.properties.category === 'Kawasan Kumuh' ? .34 : .12, dashArray: feature.properties.category === 'Kawasan Kumuh' ? '' : '5 5' }),
            onEachFeature: (feature, layer) => layer.bindTooltip(`<b>${esc(feature.properties.name)}</b><br>${esc(feature.properties.category)}`, { sticky: true }).on('click', () => { if (layer.getBounds().isValid()) map.fitBounds(layer.getBounds(), { padding: [30, 30] }); })
        }).addTo(map);
        recipientLayer = L.geoJSON({ type: 'FeatureCollection', features: allPoints }, {
            pointToLayer: (feature, latlng) => L.marker(latlng, {
                icon: L.divIcon({
                    className: 'recipient-id-icon',
                    html: `<span class="recipient-id-marker" style="--marker-color:${programColors[feature.properties.program_type_id] || '#1768bf'}">${esc(feature.properties.id)}</span>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 16],
                    popupAnchor: [0, -17],
                }),
            }),
            onEachFeature: (feature, layer) => { pointMarkers[Number(feature.properties.id)] = layer; layer.bindPopup(pointPopup(feature.properties)); layer.on('click', () => window.openRecipientDetail(feature.properties.id)); }
        }).addTo(map);
        const selectedArea = byId('area').selectedOptions[0];
        const isAreaDetail = Boolean(byId('area').value && !selectedArea?.dataset.group);
        const bounds = byId('area').value && areaLayer.getBounds().isValid() ? areaLayer.getBounds() : (recipientLayer.getBounds().isValid() ? recipientLayer.getBounds() : areaLayer.getBounds());
        if (bounds && bounds.isValid()) map.fitBounds(bounds, { padding: isAreaDetail ? [18, 18] : [30, 30], maxZoom: isAreaDetail ? 16 : 12 });
        byId('totalCount').textContent = `${data.meta.recipients} penerima`;
        byId('statTotal').textContent = data.meta.recipients; byId('statDone').textContent = data.meta.completed; byId('statProcess').textContent = data.meta.process; byId('statWaiting').textContent = data.meta.waiting;
        renderTree();
    }
    async function loadData() {
        const selectedArea = byId('area').selectedOptions[0];
        const query = new URLSearchParams({ regency_id: byId('regency').value, village_id: byId('village').value, program_type_id: byId('programType').value, area_id: selectedArea?.dataset.group ? '' : byId('area').value, area_group: selectedArea?.dataset.group || '' });
        const response = await fetch(`/geomap-data?${query}`); drawMap(await response.json());
    }
    function updateAreaOptions() {
        const regencyId = byId('regency').value;
        const areaSelect = byId('area');
        const placeholder = areaSelect.options[0];
        areaSelect.disabled = !regencyId;
        placeholder.textContent = regencyId ? 'Semua Wilayah GeoJSON' : 'Pilih Kabupaten terlebih dahulu';
        [...areaSelect.options].forEach((option, index) => {
            if (index === 0) return;
            option.hidden = !regencyId || option.dataset.regency !== regencyId;
        });
        [...areaSelect.querySelectorAll('optgroup')].forEach(group => {
            group.hidden = ![...group.querySelectorAll('option')].some(option => !option.hidden);
        });
    }
    byId('regency').onchange = () => {
        [...byId('village').options].forEach(option => option.hidden = !!option.dataset.regency && option.dataset.regency !== byId('regency').value);
        byId('village').value = '';
        byId('area').value = '';
        updateAreaOptions();
        loadData();
    };
    byId('village').onchange = loadData; byId('programType').onchange = loadData;
    byId('area').onchange = () => {
        const selected = byId('area').selectedOptions[0];
        const chip = byId('areaColorChip');
        chip.classList.toggle('show', Boolean(selected?.dataset.color || selected?.dataset.group));
        chip.querySelector('.area-color-dot').style.backgroundColor = selected?.dataset.color || 'transparent';
        chip.querySelector('span').textContent = selected?.dataset.group ? `Semua ${selected.dataset.group}` : 'Warna wilayah';
        if (selected?.dataset.regency) {
            byId('regency').value = selected.dataset.regency;
            [...byId('village').options].forEach(option => option.hidden = !!option.dataset.regency && option.dataset.regency !== selected.dataset.regency);
        }
        byId('village').value = selected?.dataset.village || '';
        loadData();
    };
    byId('searchMap').oninput = renderTree;
    byId('baseLayer').onchange = () => { map.removeLayer(baseLayer); baseLayer = L.tileLayer(tileUrls[byId('baseLayer').value], { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map); };
    byId('downloadData').onclick = () => { const rows = allPoints.map(feature => { const p = feature.properties; return [p.name, p.program_type, p.program, p.year, p.regency, p.village, p.status, p.progress]; }); const csv = ['Nama,Program,Sub Program,Tahun,Kabupaten,Desa,Status,Progress', ...rows.map(row => row.map(value => `"${String(value ?? '').replaceAll('"', '""')}"`).join(','))].join('\n'); const anchor = document.createElement('a'); anchor.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' })); anchor.download = 'penerima-mbbr.csv'; anchor.click(); URL.revokeObjectURL(anchor.href); };
    updateAreaOptions();
    loadData();
</script>
@endsection
