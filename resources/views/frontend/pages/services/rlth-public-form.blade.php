@extends('frontend.layouts.public')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<main class="public-rlth-page">
    <div class="container">
        <header class="public-rlth-hero">
            <span class="public-rlth-kicker"><i class="fas fa-house-user"></i> LAYANAN MASYARAKAT</span>
            <h1>Pendataan Rumah Tidak Layak Huni</h1>
            <p>Isi formulir berikut untuk mengajukan pendataan RTLH. Pengajuan akan diperiksa terlebih dahulu oleh petugas Dinas PKP Maluku.</p>
        </header>

        @if(session('success'))
            <div class="alert public-rlth-alert success"><i class="fas fa-circle-check"></i><div>{{ session('success') }}</div></div>
        @endif
        @if($errors->any())
            <div class="alert public-rlth-alert danger"><i class="fas fa-circle-exclamation"></i><div><strong>Data belum dapat dikirim.</strong><br>Periksa kembali isian yang diberi keterangan di bawah.</div></div>
        @endif

        <form class="public-rlth-form" method="POST" action="{{ route('public.rlth.store') }}" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="public-rlth-intro"><i class="fas fa-shield-heart"></i><span>Data pribadi Anda hanya digunakan untuk proses verifikasi pengajuan RTLH dan tidak ditampilkan kepada publik.</span></div>

            <section class="public-rlth-section">
                <div class="public-rlth-section-title"><span>1</span><div><h2>Identitas Wilayah</h2><p>Lokasi rumah yang akan didata.</p></div></div>
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label">Tahun Pendataan <b>*</b></label><input name="survey_year" type="number" class="form-control" value="{{ now()->year }}" readonly required></div>
                    <div class="col-md-4"><label class="form-label">Provinsi <b>*</b></label><input name="province_name" class="form-control @error('province_name') is-invalid @enderror" value="Maluku" readonly required>@error('province_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-5"><label class="form-label">Kabupaten/Kota <b>*</b></label><select name="regency_name" class="form-select @error('regency_name') is-invalid @enderror" required><option value="">Pilih Kabupaten/Kota</option>@foreach($malukuRegencies as $regency)<option value="{{ $regency }}" @selected(old('regency_name')===$regency)>{{ $regency }}</option>@endforeach</select>@error('regency_name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                    <div class="col-md-6"><label class="form-label">Kecamatan <b>*</b></label><input name="district_name" class="form-control @error('district_name') is-invalid @enderror" value="{{ old('district_name') }}" required></div>
                    <div class="col-md-6"><label class="form-label">Desa/Kelurahan <b>*</b></label><input name="village_name" class="form-control @error('village_name') is-invalid @enderror" value="{{ old('village_name') }}" required></div>
                    <div class="col-12"><label class="form-label">Alamat Lengkap <b>*</b></label><textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required placeholder="Jalan, RT/RW, dusun, nomor rumah, dan keterangan lokasi">{{ old('address') }}</textarea></div>
                </div>
            </section>

            <section class="public-rlth-section">
                <div class="public-rlth-section-title"><span>2</span><div><h2>Identitas Keluarga</h2><p>Data kepala keluarga penghuni rumah.</p></div></div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Nama Kepala Keluarga <b>*</b></label><input name="head_of_family_name" class="form-control @error('head_of_family_name') is-invalid @enderror" value="{{ old('head_of_family_name') }}" required></div>
                    <div class="col-md-6"><label class="form-label">Nomor Kartu Keluarga <b>*</b></label><input name="family_card_number" id="familyCardNumber" inputmode="numeric" maxlength="16" class="form-control @error('family_card_number') is-invalid @enderror" value="{{ old('family_card_number') }}" required placeholder="16 digit Nomor KK"><small id="familyCardFeedback" class="public-field-feedback" aria-live="polite"></small></div>
                    <div class="col-md-6"><label class="form-label">NIK <b>*</b></label><input name="national_id" inputmode="numeric" maxlength="32" class="form-control @error('national_id') is-invalid @enderror" value="{{ old('national_id') }}" required placeholder="Nomor identitas kependudukan"></div>
                    <div class="col-md-3"><label class="form-label">Jumlah Anggota Keluarga <b>*</b></label><input type="number" name="family_member_count" min="1" max="99" class="form-control @error('family_member_count') is-invalid @enderror" value="{{ old('family_member_count') }}" required></div>
                    <div class="col-md-3"><label class="form-label">ID Pelanggan PLN</label><input name="pln_customer_id" class="form-control" value="{{ old('pln_customer_id') }}" placeholder="Opsional"></div>
                    <div class="col-md-4"><label class="form-label">Nomor HP <b>*</b></label><input name="phone" inputmode="tel" class="form-control" value="{{ old('phone') }}" placeholder="Contoh: 0812xxxx" required></div>
                    <div class="col-md-4"><label class="form-label">Pekerjaan <b>*</b></label><input name="occupation" class="form-control" value="{{ old('occupation') }}" placeholder="Contoh: Petani" required></div>
                    <div class="col-md-4"><label class="form-label">Penghasilan <b>*</b></label><select name="income_range" class="form-select" required><option value="">Pilih penghasilan</option>@foreach(['< 2.000.000','2.000.000 - 5.000.000','> 5.000.000'] as $income)<option value="{{ $income }}" @selected(old('income_range')===$income)>{{ $income }}</option>@endforeach</select></div>
                </div>
            </section>

            <section class="public-rlth-section">
                <div class="public-rlth-section-title"><span>3</span><div><h2>Sosial Ekonomi dan Desil</h2><p>Data sosial ekonomi dan kepemilikan keluarga.</p></div></div>
                <div class="row g-3">
                    @foreach(['national_decile'=>'Desil Nasional','provincial_decile'=>'Desil Provinsi','regency_decile'=>'Desil Kabupaten/Kota'] as $field=>$label)
                    <div class="col-md-4"><label class="form-label">{{ $label }} <b>*</b></label><select name="{{ $field }}" class="form-select" required><option value="">Pilih</option>@for($i=1;$i<=10;$i++)<option value="{{ $i }}" @selected((string)old($field)===(string)$i)>{{ $i }}</option>@endfor</select></div>
                    @endforeach
                    @foreach(['national_pbi'=>'PBI Nasional','local_pbi'=>'PBI Pemda'] as $field=>$label)
                    <div class="col-md-6"><label class="form-label">{{ $label }} <b>*</b></label><select name="{{ $field }}" class="form-select" required><option value="">Pilih</option><option value="Ya" @selected(old($field)==='Ya')>Ya</option><option value="Tidak" @selected(old($field)==='Tidak')>Tidak</option></select></div>
                    @endforeach
                    @foreach(['land_ownership'=>'Status Kepemilikan Tanah','other_assets'=>'Kepemilikan Aset Tempat Lain'] as $field=>$label)
                    <div class="col-md-6"><label class="form-label">{{ $label }} <b>*</b></label><select name="{{ $field }}" class="form-select" required><option value="">Pilih</option><option value="Ya" @selected(old($field)==='Ya')>Ya</option><option value="Tidak" @selected(old($field)==='Tidak')>Tidak</option></select></div>
                    @endforeach
                </div>
            </section>

            <section class="public-rlth-section">
                <div class="public-rlth-section-title"><span>4</span><div><h2>Kondisi Fisik Rumah</h2><p>Gambarkan kondisi bangunan saat ini.</p></div></div>
                <div class="row g-3">
                    <div class="col-md-6"><label class="form-label">Status Kepemilikan Rumah <b>*</b></label><select name="house_ownership" class="form-select" required><option value="">Pilih</option>@foreach(['Milik sendiri','Sewa/kontrak','Bebas sewa','Dinas','Lainnya'] as $item)<option @selected(old('house_ownership')===$item)>{{ $item }}</option>@endforeach</select></div>
                    <div class="col-md-6"><label class="form-label">Jenis Lantai Terluas <b>*</b></label><select name="floor_type" class="form-select" required><option value="">Pilih</option>@foreach(['Marmer/granit','Keramik','Parket/vinil','Semen/bata merah','Tanah','Lainnya'] as $item)<option @selected(old('floor_type')===$item)>{{ $item }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Luas Lantai (m²) <b>*</b></label><input type="number" name="building_area" min="0" step="0.1" class="form-control" value="{{ old('building_area') }}" required></div>
                    <div class="col-md-4"><label class="form-label">Jenis Dinding Terluas <b>*</b></label><select name="wall_type" class="form-select" required><option value="">Pilih</option>@foreach(['Tembok','Plesteran anyaman bambu/kawat','Kayu/papan/gypsum/GRC/calciboard','Anyaman bambu','Lainnya'] as $item)<option @selected(old('wall_type')===$item)>{{ $item }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Jenis Atap Terluas <b>*</b></label><select name="roof_material" class="form-select" required><option value="">Pilih</option>@foreach(['Beton','Genteng','Seng','Asbes','Daun/rumbia','Lainnya'] as $item)<option @selected(old('roof_material')===$item)>{{ $item }}</option>@endforeach</select></div>
                    @foreach(['foundation_condition'=>'Kondisi Pondasi Rumah','beam_column_condition'=>'Kondisi Balok dan Kolom','roof_damage_level'=>'Tingkat Kerusakan Atap'] as $field=>$label)
                    <div class="col-md-4"><label class="form-label">{{ $label }} <b>*</b></label><select name="{{ $field }}" class="form-select" required><option value="">Pilih</option>@foreach(['Rusak Berat','Rusak Sedang','Rusak Ringan'] as $item)<option @selected(old($field)===$item)>{{ $item }}</option>@endforeach</select></div>
                    @endforeach
                    @foreach(['window_availability'=>'Ketersediaan Jendela','ventilation_availability'=>'Ketersediaan Ventilasi','mck_availability'=>'Ketersediaan MCK'] as $field=>$label)
                    <div class="col-md-4"><label class="form-label">{{ $label }} <b>*</b></label><select name="{{ $field }}" class="form-select" required><option value="">Pilih</option><option value="Ada" @selected(old($field)==='Ada')>Ada</option><option value="Tidak" @selected(old($field)==='Tidak')>Tidak</option></select></div>
                    @endforeach
                </div>
            </section>

            <section class="public-rlth-section">
                <div class="public-rlth-section-title"><span>5</span><div><h2>Utilitas Rumah</h2><p>Ketersediaan layanan dasar di rumah.</p></div></div>
                <div class="row g-3">
                    @foreach(['water_source'=>['Sumber Air Minum Utama','Contoh: PDAM, sumur, mata air'],'electricity_source'=>['Sumber Penerangan Utama','PLN / non-PLN'],'electricity_capacity'=>['Daya Terpasang','Contoh: 450 VA'],'cooking_fuel'=>['Bahan Bakar Utama Memasak','Contoh: LPG 3 kg'],'toilet_facility'=>['Fasilitas BAB','Ada sendiri / bersama / tidak ada'],'toilet_type'=>['Jenis Kloset','Leher angsa / plengsengan / lainnya'],'sewage_disposal'=>['Pembuangan Akhir Tinja','Septic tank / sungai / lainnya']] as $field=>[$label,$placeholder])
                    <div class="col-md-6"><label class="form-label">{{ $label }} <b>*</b></label><input name="{{ $field }}" class="form-control" value="{{ old($field) }}" placeholder="{{ $placeholder }}" required></div>
                    @endforeach
                </div>
            </section>

            <section class="public-rlth-section">
                <div class="public-rlth-section-title"><span>6</span><div><h2>Lokasi dan Dokumentasi</h2><p>Foto depan wajib diunggah. Gunakan tombol lokasi bila tersedia di perangkat Anda.</p></div></div>
                <div class="public-location-actions"><button type="button" class="btn btn-outline-primary" id="getLocation"><i class="fas fa-location-crosshairs me-1"></i> Ambil Lokasi Saat Ini</button><span id="locationMessage" aria-live="polite"></span></div>
                <div id="rlthLocationMap" class="public-location-map" aria-label="Peta penentuan lokasi rumah"></div>
                <p class="public-location-hint"><i class="fas fa-hand-pointer me-1"></i>Klik peta atau geser penanda untuk menentukan titik lokasi rumah.</p>
                <div class="row g-3 mb-3"><div class="col-md-6"><label class="form-label">Latitude</label><input name="latitude" id="latitude" class="form-control" readonly value="{{ old('latitude') }}"></div><div class="col-md-6"><label class="form-label">Longitude</label><input name="longitude" id="longitude" class="form-control" readonly value="{{ old('longitude') }}"></div></div>
                <div class="row g-3">
                    @foreach(['photo_front'=>'Foto Tampak Depan Rumah','photo_left'=>'Foto Tampak Samping Kiri','photo_right'=>'Foto Tampak Samping Kanan','photo_back'=>'Foto Tampak Belakang','photo_roof'=>'Foto Atap Bagian Dalam','photo_window'=>'Foto Jendela','photo_mck'=>'Foto MCK'] as $field=>$label)
                    <div class="col-md-6"><label class="public-photo-field @error($field) has-error @enderror"><i class="fas fa-camera"></i><span><strong>{{ $label }} *</strong><small>JPG, PNG, atau WEBP · maks. 5 MB</small></span><input type="file" name="{{ $field }}" accept="image/jpeg,image/png,image/webp" required><img class="public-photo-preview" alt="Pratinjau {{ $label }}" hidden></label>@error($field)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</div>
                    @endforeach
                </div>
            </section>

            <section class="public-rlth-consent"><label><input type="checkbox" name="consent" value="1" @checked(old('consent')) required><span>Saya menyatakan data yang saya isi benar dan bersedia data ini diproses oleh Dinas PKP Maluku untuk verifikasi pendataan RTLH.</span></label>@error('consent')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror</section>
            <div class="public-rlth-submit"><a href="/pendataan-rlth" class="btn btn-light border">Kembali ke Data RTLH</a><button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane me-2"></i>Kirim Pendataan</button></div>
        </form>
    </div>
</main>

<style>
.public-rlth-page{padding:48px 0 72px;background:linear-gradient(150deg,#eef7f8 0,#f8fbfb 42%,#fff9ed 100%)}
.public-rlth-hero{max-width:830px;margin:0 auto 28px;text-align:center}.public-rlth-kicker{display:inline-flex;gap:8px;align-items:center;color:#94733d;font-weight:800;font-size:.8rem;letter-spacing:.08em}.public-rlth-hero h1{margin:10px 0;color:#183c50;font-size:clamp(1.8rem,3vw,2.55rem);font-weight:900}.public-rlth-hero p{margin:0;color:#60727a;font-size:1.05rem;line-height:1.7}.public-rlth-alert{display:flex;gap:12px;align-items:flex-start;border:0;border-radius:14px;padding:16px 20px}.public-rlth-alert i{font-size:1.25rem;margin-top:2px}.public-rlth-alert.success{background:#e7f7ee;color:#14663d}.public-rlth-alert.danger{background:#fff0f0;color:#9d2d2d}.public-rlth-form{max-width:1000px;margin:auto;padding:30px;background:#fff;border:1px solid #dce9eb;border-radius:22px;box-shadow:0 15px 42px #183c5014}.public-rlth-intro{display:flex;align-items:center;gap:12px;margin-bottom:26px;padding:14px 17px;border-radius:12px;background:#eef8f8;color:#386370;font-size:.92rem}.public-rlth-intro i{color:#16807c;font-size:1.25rem}.public-rlth-section{padding:27px 0;border-bottom:1px solid #e5eef0}.public-rlth-section:first-of-type{padding-top:0}.public-rlth-section-title{display:flex;gap:13px;align-items:flex-start;margin-bottom:19px}.public-rlth-section-title>span{display:grid;place-items:center;width:34px;height:34px;flex:0 0 34px;border-radius:10px;background:#c5a35f;color:#fff;font-weight:900}.public-rlth-section h2{margin:0 0 2px;color:#183c50;font-size:1.15rem;font-weight:850}.public-rlth-section p{margin:0;color:#72838a;font-size:.9rem}.public-rlth-form .form-label{margin-bottom:6px;color:#405960;font-size:.9rem;font-weight:750}.public-rlth-form .form-label b{color:#c05252}.public-rlth-form .form-control,.public-rlth-form .form-select{min-height:44px;border-color:#d5e2e5;border-radius:10px}.public-rlth-form textarea.form-control{min-height:auto}.public-rlth-form .form-control:focus,.public-rlth-form .form-select:focus{border-color:#4d9295;box-shadow:0 0 0 .2rem #4d929520}.public-location-actions{display:flex;align-items:center;flex-wrap:wrap;gap:11px;margin:-2px 0 16px}.public-location-actions span{color:#61747b;font-size:.88rem}.public-photo-field{display:flex;align-items:center;gap:13px;min-height:86px;margin:0;padding:15px;border:1px dashed #b7ced2;border-radius:13px;background:#f9fcfc;cursor:pointer}.public-photo-field:hover{border-color:#4d9295;background:#f1f9f9}.public-photo-field.has-error{border-color:#dc6a6a}.public-photo-field>i{display:grid;place-items:center;width:40px;height:40px;border-radius:10px;background:#e2f1f1;color:#16807c}.public-photo-field span{display:flex;flex-direction:column;gap:2px}.public-photo-field strong{color:#304e59;font-size:.92rem}.public-photo-field small{color:#74858a}.public-photo-field input{width:0;height:0;opacity:0;position:absolute}.public-rlth-consent{margin-top:26px;padding:17px;border-radius:12px;background:#fff8e9;color:#5d5a50;font-size:.91rem;line-height:1.55}.public-rlth-consent label{display:flex;gap:10px;align-items:flex-start}.public-rlth-consent input{margin-top:4px;accent-color:#2d7779}.public-rlth-submit{display:flex;justify-content:flex-end;gap:12px;margin-top:26px}.public-rlth-submit .btn{padding:11px 20px;border-radius:10px;font-weight:750}@media(max-width:576px){.public-rlth-page{padding:32px 0 48px}.public-rlth-form{padding:20px 16px;border-radius:16px}.public-rlth-intro{align-items:flex-start}.public-rlth-submit{flex-direction:column-reverse}.public-rlth-submit .btn{width:100%}}
 .public-rlth-tabs{display:grid;grid-template-columns:repeat(6,1fr);gap:7px;margin:0 0 27px}.public-rlth-tab{display:flex;align-items:center;gap:8px;min-width:0;padding:10px;border:1px solid #dbe7e9;border-radius:10px;background:#fff;color:#718187;font-size:.76rem;font-weight:750;text-align:left}.public-rlth-tab span{display:grid;place-items:center;flex:0 0 23px;width:23px;height:23px;border-radius:50%;background:#edf2f3;color:#63747b;font-size:.72rem}.public-rlth-tab.active{border-color:#398184;background:#eef8f7;color:#246b6e}.public-rlth-tab.active span{background:#2e7d7f;color:#fff}.public-rlth-tab.done{border-color:#bddfdc;color:#397477}.public-rlth-tab.done span{background:#d9efed;color:#267477}.public-rlth-tab:disabled{opacity:1}.public-rlth-step-controls{display:flex;justify-content:space-between;gap:12px;margin-top:26px}.public-rlth-step-controls .btn{padding:11px 20px;border-radius:10px;font-weight:750}@media(max-width:767px){.public-rlth-tabs{grid-template-columns:repeat(3,1fr)}.public-rlth-tab{justify-content:center;padding:9px}.public-rlth-tab em{display:none}}@media(max-width:576px){.public-rlth-step-controls{flex-direction:column-reverse}.public-rlth-step-controls .btn{width:100%}}
.public-location-map{height:310px;margin:3px 0 8px;overflow:hidden;border:1px solid #c7dddf;border-radius:14px;background:#e5f0f1}.public-location-hint{margin:0 0 16px;color:#657b81;font-size:.84rem}.public-photo-field span{flex:1}.public-photo-preview{width:64px;height:54px;flex:0 0 64px;border:1px solid #b8d4d3;border-radius:8px;object-fit:cover;background:#fff}@media(max-width:576px){.public-location-map{height:250px}}
.public-field-feedback{display:block;min-height:18px;margin-top:4px;font-size:.78rem;font-weight:650}.public-field-feedback.valid{color:#177467}.public-field-feedback.invalid{color:#be4242}
</style>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.public-rlth-form');
    const sections = Array.from(form.querySelectorAll('.public-rlth-section'));
    const consent = form.querySelector('.public-rlth-consent');
    const submit = form.querySelector('.public-rlth-submit');
    const labels = ['Wilayah', 'Keluarga', 'Sosial Ekonomi', 'Kondisi Rumah', 'Utilitas', 'Lokasi & Foto'];
    const tabs = document.createElement('nav');
    tabs.className = 'public-rlth-tabs'; tabs.setAttribute('aria-label', 'Tahapan pendataan RTLH');
    tabs.innerHTML = labels.map((label, index) => `<button type="button" class="public-rlth-tab" data-step="${index}"><span>${index + 1}</span><em>${label}</em></button>`).join('');
    form.querySelector('.public-rlth-intro').after(tabs);
    const controls = document.createElement('div');
    controls.className = 'public-rlth-step-controls';
    controls.innerHTML = '<button type="button" class="btn btn-light border" id="previousStep"><i class="fas fa-arrow-left me-1"></i> Kembali</button><button type="button" class="btn btn-primary" id="nextStep">Lanjut <i class="fas fa-arrow-right ms-1"></i></button>';
    submit.before(controls);
    let current = sections.findIndex(section => section.querySelector('.is-invalid'));
    if (current < 0) current = 0;
    const showStep = (index, shouldScroll = false) => {
        current = Math.max(0, Math.min(index, sections.length - 1));
        sections.forEach((section, i) => section.hidden = i !== current);
        consent.hidden = current !== sections.length - 1;
        submit.hidden = current !== sections.length - 1;
        controls.querySelector('#previousStep').hidden = current === 0;
        controls.querySelector('#nextStep').hidden = current === sections.length - 1;
        tabs.querySelectorAll('.public-rlth-tab').forEach((tab, i) => {
            tab.classList.toggle('active', i === current); tab.classList.toggle('done', i < current); tab.disabled = i > current;
        });
        if (current === sections.length - 1 && locationMap) setTimeout(() => locationMap.invalidateSize(), 100);
        if (shouldScroll) window.scrollTo({ top: form.getBoundingClientRect().top + window.scrollY - 90, behavior: 'smooth' });
    };
    const validateCurrentStep = () => {
        for (const input of sections[current].querySelectorAll('input, select, textarea')) {
            if (!input.checkValidity()) { input.reportValidity(); return false; }
        }
        return true;
    };
    form.addEventListener('submit', event => {
        for (let index = 0; index < sections.length; index++) {
            for (const input of sections[index].querySelectorAll('input, select, textarea')) {
                if (!input.checkValidity()) {
                    event.preventDefault();
                    showStep(index, true);
                    setTimeout(() => input.reportValidity(), 250);
                    return;
                }
            }
        }
        const consentInput = consent.querySelector('input[name="consent"]');
        if (!consentInput.checkValidity()) {
            event.preventDefault();
            consentInput.reportValidity();
        }
    });
    controls.querySelector('#nextStep').addEventListener('click', () => { if (validateCurrentStep()) showStep(current + 1, true); });
    controls.querySelector('#previousStep').addEventListener('click', () => showStep(current - 1, true));
    tabs.addEventListener('click', event => { const tab = event.target.closest('.public-rlth-tab'); if (tab && Number(tab.dataset.step) <= current) showStep(Number(tab.dataset.step), true); });
    const allowedImageTypes = ['image/jpeg', 'image/png', 'image/webp'];
    form.querySelectorAll('.public-photo-field input[type="file"]').forEach(input => input.addEventListener('change', function () {
        const preview = this.closest('.public-photo-field').querySelector('.public-photo-preview');
        const file = this.files?.[0];
        if (!file) { preview.hidden = true; preview.removeAttribute('src'); return; }
        if (!allowedImageTypes.includes(file.type) || file.size > 5 * 1024 * 1024) {
            this.value = ''; preview.hidden = true; preview.removeAttribute('src');
            if (window.Swal) Swal.fire({icon:'error',title:'File tidak dapat digunakan',text:'Pilih gambar JPG, PNG, atau WEBP dengan ukuran maksimal 5 MB.'});
            else window.alert('Pilih gambar JPG, PNG, atau WEBP dengan ukuran maksimal 5 MB.');
            return;
        }
        const source = URL.createObjectURL(file);
        preview.onload = () => URL.revokeObjectURL(source);
        preview.src = source; preview.hidden = false;
    }));
    const familyCardInput = document.getElementById('familyCardNumber');
    const familyCardFeedback = document.getElementById('familyCardFeedback');
    let familyCardTimer;
    familyCardInput?.addEventListener('input', function () {
        const value = this.value.replace(/\D/g, '').slice(0, 16);
        this.value = value; this.setCustomValidity('');
        clearTimeout(familyCardTimer);
        if (!value) { familyCardFeedback.textContent = ''; familyCardFeedback.className = 'public-field-feedback'; return; }
        if (value.length < 16) { familyCardFeedback.textContent = 'Nomor KK harus terdiri dari 16 digit.'; familyCardFeedback.className = 'public-field-feedback invalid'; return; }
        familyCardFeedback.textContent = 'Memeriksa Nomor KK...'; familyCardFeedback.className = 'public-field-feedback';
        familyCardTimer = setTimeout(async () => {
            try {
                const response = await fetch(`{{ route('public.rlth.check-family-card') }}?family_card_number=${encodeURIComponent(value)}`, {headers:{Accept:'application/json'}});
                const result = await response.json();
                familyCardFeedback.textContent = result.message;
                familyCardFeedback.className = `public-field-feedback ${result.available ? 'valid' : 'invalid'}`;
                familyCardInput.setCustomValidity(result.available ? '' : result.message);
            } catch (_) { familyCardFeedback.textContent = 'Pemeriksaan Nomor KK tidak tersedia. Data tetap diperiksa saat dikirim.'; familyCardFeedback.className = 'public-field-feedback'; }
        }, 350);
    });
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    let locationMap, locationMarker;
    const updateMapPoint = (latitude, longitude, zoom = 15) => {
        latitudeInput.value = Number(latitude).toFixed(7);
        longitudeInput.value = Number(longitude).toFixed(7);
        if (!locationMap) return;
        const point = [Number(latitude), Number(longitude)];
        if (!locationMarker) {
            locationMarker = L.marker(point, {draggable:true}).addTo(locationMap);
            locationMarker.on('dragend', () => { const markerPoint = locationMarker.getLatLng(); updateMapPoint(markerPoint.lat, markerPoint.lng, locationMap.getZoom()); });
        } else locationMarker.setLatLng(point);
        locationMap.setView(point, zoom);
    };
    if (window.L) {
        const existingLatitude = Number(latitudeInput.value);
        const existingLongitude = Number(longitudeInput.value);
        const defaultPoint = Number.isFinite(existingLatitude) && Number.isFinite(existingLongitude) ? [existingLatitude, existingLongitude] : [-3.6547, 128.1906];
        locationMap = L.map('rlthLocationMap').setView(defaultPoint, Number.isFinite(existingLatitude) ? 14 : 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom:19,attribution:'© OpenStreetMap'}).addTo(locationMap);
        if (Number.isFinite(existingLatitude) && Number.isFinite(existingLongitude)) updateMapPoint(existingLatitude, existingLongitude, 14);
        locationMap.on('click', event => updateMapPoint(event.latlng.lat, event.latlng.lng));
    }
    document.getElementById('getLocation')?.addEventListener('click', function () {
    const message = document.getElementById('locationMessage');
    if (!navigator.geolocation) { message.textContent = 'Perangkat ini tidak mendukung pengambilan lokasi.'; return; }
    message.textContent = 'Mengambil lokasi...';
    navigator.geolocation.getCurrentPosition(function (position) {
            updateMapPoint(position.coords.latitude, position.coords.longitude);
        message.textContent = 'Lokasi berhasil diisi.';
    }, function () { message.textContent = 'Lokasi tidak dapat diambil. Izinkan akses lokasi atau lanjutkan tanpa koordinat.'; }, { enableHighAccuracy: true, timeout: 10000 });
    });
    showStep(current);
});
</script>
@endsection
