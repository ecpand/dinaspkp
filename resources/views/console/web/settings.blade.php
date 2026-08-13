@include('console.nav', ['title' => 'Website Setting'])

<div class="card overflow-hidden">
    <div class="p-4 border-bottom d-flex align-items-center gap-3">
        <span class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary-subtle text-primary" style="width:46px;height:46px"><i class="fa fa-sliders fs-5"></i></span>
        <div>
            <h2 class="h5 mb-1">Pengaturan Website</h2>
            <p class="text-secondary small mb-0">Data ini digunakan pada header, footer, dan halaman kontak website.</p>
        </div>
    </div>

    <form method="post" action="/console/kelola-web/pengaturan-website" enctype="multipart/form-data" class="p-4">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <h3 class="h6 text-primary fw-bold mb-3"><i class="fa fa-building me-2"></i>Identitas Instansi</h3>
                <div class="row g-3">
                    <div class="col-md-8"><label class="form-label">Nama Instansi <span class="text-danger">*</span></label><input name="agency_name" class="form-control" value="{{ old('agency_name', $setting?->agency_name) }}" required></div>
                    <div class="col-md-4"><label class="form-label">Nama Singkat</label><input name="short_name" class="form-control" value="{{ old('short_name', $setting?->short_name) }}" placeholder="Contoh: Dinas PKP Maluku"></div>
                    <div class="col-md-6"><label class="form-label">Nomor Telepon</label><input name="phone" class="form-control" value="{{ old('phone', $setting?->phone) }}" placeholder="Contoh: (0911) 123456"></div>
                    <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $setting?->email) }}" placeholder="email@malukuprov.go.id"></div>
                    <div class="col-12"><label class="form-label">Alamat Kantor</label><textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap kantor">{{ old('address', $setting?->address) }}</textarea></div>
                    <div class="col-12"><label class="form-label">Website</label><input name="website" class="form-control" value="{{ old('website', $setting?->website) }}" placeholder="dinaspkp.malukuprov.go.id"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="rounded-3 bg-light border p-3 h-100">
                    <h3 class="h6 text-primary fw-bold mb-3"><i class="fa fa-image me-2"></i>Logo & Favicon</h3>
                    <div class="bg-white border rounded-3 d-flex align-items-center justify-content-center mb-3" style="height:155px">
                        <img id="logoPreview" src="{{ $setting?->logo_path ? asset('storage/'.$setting->logo_path) : asset('assets/img/logo.png') }}" alt="Preview logo" style="max-width:130px;max-height:130px;object-fit:contain">
                    </div>
                    <input type="file" name="logo" id="logoInput" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*">
                    <small class="text-secondary d-block mt-2">JPG, PNG, atau WEBP. Maksimal 2 MB.</small>
                    <hr class="my-3">
                    <div class="d-flex align-items-center gap-3 mb-2"><img id="faviconPreview" src="{{ $setting?->favicon_path ? asset('storage/'.$setting->favicon_path) : asset('assets/img/logo.png') }}" alt="Preview favicon" style="width:34px;height:34px;object-fit:contain"><label class="form-label mb-0">Favicon Browser</label></div>
                    <input type="file" name="favicon" id="faviconInput" class="form-control" accept=".ico,.png,image/x-icon,image/png">
                    <small class="text-secondary d-block mt-2">ICO atau PNG. Disarankan ukuran 32×32 atau 48×48 px, maksimal 1 MB.</small>
                </div>
            </div>
        </div>

        <hr class="my-4">
        <h3 class="h6 text-primary fw-bold mb-3"><i class="fa fa-share-nodes me-2"></i>Media Sosial</h3>
        <div class="row g-3">
            @foreach(['facebook' => ['Facebook', 'fa-facebook-f'], 'instagram' => ['Instagram', 'fa-instagram'], 'youtube' => ['YouTube', 'fa-youtube']] as $field => [$label, $icon])
                <div class="col-md-4">
                    <label class="form-label"><i class="fab {{ $icon }} me-1"></i>{{ $label }}</label>
                    <input type="url" name="{{ $field }}" class="form-control" value="{{ old($field, $setting?->social_links[$field] ?? '') }}" placeholder="https://{{ $field }}.com/...">
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end gap-2 border-top mt-4 pt-4">
            <a href="/console/kelola-web" class="btn btn-light border">Batal</a>
            <button class="btn btn-primary px-4"><i class="fa fa-floppy-disk me-2"></i>Simpan Pengaturan</button>
        </div>
    </form>
</div>

<script>
document.getElementById('logoInput')?.addEventListener('change', function () {
    const file = this.files?.[0];
    if (file) document.getElementById('logoPreview').src = URL.createObjectURL(file);
});
document.getElementById('faviconInput')?.addEventListener('change', function () {
    const file = this.files?.[0];
    if (file) document.getElementById('faviconPreview').src = URL.createObjectURL(file);
});
</script>

@include('console.end')
