@php
    $yesNo = ['Ya', 'Tidak'];
    $damageLevels = ['Rusak Berat', 'Rusak Sedang', 'Rusak Ringan'];
    $conditionOptions = [
        'foundation_condition' => ['Kondisi Pondasi Rumah', $damageLevels],
        'beam_column_condition' => ['Kondisi Balok dan Kolom', $damageLevels],
        'window_availability' => ['Ketersediaan Jendela', ['Ada', 'Tidak']],
        'ventilation_availability' => ['Ketersediaan Ventilasi', ['Ada', 'Tidak']],
        'mck_availability' => ['Ketersediaan MCK', ['Ada', 'Tidak']],
        'water_source' => ['Ketersediaan Air Bersih', ['Sumur', 'Sumur dengan pompa']],
        'wall_type' => ['Jenis Dinding', ['Kayu', 'Beton']],
        'roof_material' => ['Material Atap', ['Seng', 'Genteng', 'Daun']],
        'roof_damage_level' => ['Tingkat Kerusakan Atap', $damageLevels],
    ];
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form method="post" action="{{ $action }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            @if($record) @method('PUT') @endif
            <div class="modal-header"><h2 class="fs-5"><i class="fa fa-house-crack me-2"></i>{{ $record ? 'Edit' : 'Tambah' }} Data RLTH</h2><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <h3 class="h6 text-primary border-bottom pb-2">Identitas dan Lokasi</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-2"><label class="form-label">Tahun</label><input type="number" name="survey_year" min="2000" max="2100" value="{{ $record?->survey_year ?? now()->year }}" class="form-control"></div>
                    <div class="col-md-5"><label class="form-label">Nama</label><input name="name" value="{{ $record?->name }}" class="form-control" required></div>
                    <div class="col-md-5"><label class="form-label">Nomor HP</label><input name="phone" value="{{ $record?->phone }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Nomor KTP / NIK</label><input name="national_id" value="{{ $record?->national_id }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Nomor KK</label><input name="family_card_number" value="{{ $record?->family_card_number }}" class="form-control"></div>
                    <div class="col-md-6"><label class="form-label">Alamat</label><input name="address" value="{{ $record?->address }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Provinsi</label><input name="province_name" value="{{ $record?->province_name ?? 'Maluku' }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Kabupaten / Kota</label><input name="regency_name" value="{{ $record?->regency_name }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Kelurahan / Desa</label><input name="village_name" value="{{ $record?->village_name }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Kecamatan</label><input name="district_name" value="{{ $record?->district_name }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Latitude</label><input name="latitude" type="number" step="0.0000001" value="{{ $record?->latitude }}" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">Longitude</label><input name="longitude" type="number" step="0.0000001" value="{{ $record?->longitude }}" class="form-control"></div>
                </div>

                <h3 class="h6 text-primary border-bottom pb-2">Sosial Ekonomi</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><label class="form-label">Pekerjaan</label><input name="occupation" value="{{ $record?->occupation }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Penghasilan</label><select name="income_range" class="form-select"><option value="">Pilih penghasilan</option>@foreach(['< 2.000.000', '2.000.000 - 5.000.000', '> 5.000.000'] as $option)<option value="{{ $option }}" @selected($record?->income_range === $option)>{{ $option }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Luas Bangunan (m²)</label><input name="building_area" type="number" step="0.01" min="0" value="{{ $record?->building_area }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Jumlah Anggota Keluarga</label><input name="family_member_count" type="number" min="1" value="{{ $record?->family_member_count }}" class="form-control"></div>
                    <div class="col-md-4"><label class="form-label">Desil Nasional</label><select name="national_decile" class="form-select"><option value="">Pilih</option>@for($i=1;$i<=10;$i++)<option value="{{ $i }}" @selected($record?->national_decile==$i)>{{ $i }}</option>@endfor</select></div>
                    <div class="col-md-4"><label class="form-label">Desil Provinsi</label><select name="provincial_decile" class="form-select"><option value="">Pilih</option>@for($i=1;$i<=10;$i++)<option value="{{ $i }}" @selected($record?->provincial_decile==$i)>{{ $i }}</option>@endfor</select></div>
                    <div class="col-md-4"><label class="form-label">Desil Kabupaten/Kota</label><select name="regency_decile" class="form-select"><option value="">Pilih</option>@for($i=1;$i<=10;$i++)<option value="{{ $i }}" @selected($record?->regency_decile==$i)>{{ $i }}</option>@endfor</select></div>
                    @foreach(['national_pbi'=>'PBI Nasional','local_pbi'=>'PBI Pemda'] as $field=>$label)<div class="col-md-4"><label class="form-label">{{ $label }}</label><select name="{{ $field }}" class="form-select"><option value="">Pilih</option>@foreach($yesNo as $option)<option value="{{ $option }}" @selected($record?->{$field}===$option)>{{ $option }}</option>@endforeach</select></div>@endforeach
                    @foreach(['house_ownership' => 'Status Kepemilikan Rumah', 'land_ownership' => 'Status Kepemilikan Tanah', 'other_assets' => 'Kepemilikan Aset Tempat Lain'] as $field => $label)
                        <div class="col-md-4"><label class="form-label">{{ $label }}</label><select name="{{ $field }}" class="form-select"><option value="">Pilih status</option>@foreach($yesNo as $option)<option value="{{ $option }}" @selected($record?->{$field} === $option)>{{ $option }}</option>@endforeach</select></div>
                    @endforeach
                </div>

                <h3 class="h6 text-primary border-bottom pb-2">Kondisi Rumah</h3>
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><label class="form-label">Jenis Lantai</label><input name="floor_type" value="{{ $record?->floor_type }}" class="form-control"></div>
                    @foreach($conditionOptions as $field => [$label, $options])
                        <div class="col-md-4"><label class="form-label">{{ $label }}</label><select name="{{ $field }}" class="form-select"><option value="">Pilih {{ strtolower($label) }}</option>@foreach($options as $option)<option value="{{ $option }}" @selected($record?->{$field} === $option)>{{ $option }}</option>@endforeach</select></div>
                    @endforeach
                </div>

                <h3 class="h6 text-primary border-bottom pb-2">Utilitas Rumah</h3>
                <div class="row g-3 mb-4">@foreach(['water_source'=>'Sumber Air Minum','electricity_source'=>'Sumber Penerangan','electricity_capacity'=>'Daya Terpasang','cooking_fuel'=>'Bahan Bakar Memasak','toilet_facility'=>'Fasilitas BAB','toilet_type'=>'Jenis Kloset','sewage_disposal'=>'Pembuangan Akhir Tinja'] as $field=>$label)<div class="col-md-4"><label class="form-label">{{ $label }}</label><input name="{{ $field }}" value="{{ $record?->{$field} }}" class="form-control"></div>@endforeach</div>

                <h3 class="h6 text-primary border-bottom pb-2">Dokumentasi Rumah <small class="text-secondary fw-normal">JPG, PNG, WEBP maksimal 5 MB per foto</small></h3>
                <div class="row g-3">
                    @foreach(['photo_front' => 'Tampak Depan', 'photo_left' => 'Tampak Samping Kiri', 'photo_right' => 'Tampak Samping Kanan', 'photo_back' => 'Tampak Belakang', 'photo_roof' => 'Atap Bagian Dalam', 'photo_window' => 'Jendela', 'photo_mck' => 'MCK'] as $field => $label)
                        @php($pathField = $field.'_path')
                        <div class="col-md-4"><label class="form-label">{{ $label }}</label>@if($record?->{$pathField})<a href="{{ $record->photoUrl($pathField) }}" target="_blank" class="d-block small mb-1 text-success"><i class="fa fa-image"></i> Foto tersedia</a>@endif<input name="{{ $field }}" type="file" accept="image/jpeg,image/png,image/webp" class="form-control"></div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary"><i class="fa fa-floppy-disk me-1"></i>Simpan Data RLTH</button></div>
        </form>
    </div>
</div>
