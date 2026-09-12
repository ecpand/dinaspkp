@php
    $location = collect([$record->province_name, $record->regency_name, $record->district_name, $record->village_name])
        ->filter()
        ->join(', ');
    $detailItems = [
        'Nama Kepala Keluarga' => $record->name,
        'Nomor KK' => $record->family_card_number,
        'NIK' => $record->national_id,
        'Wilayah' => $location,
        'Alamat' => $record->address,
        'Anggota Keluarga' => $record->family_member_count,
        'Status Rumah' => $record->house_ownership,
        'Luas Bangunan' => $record->building_area ? $record->building_area.' m²' : null,
        'Jenis Lantai' => $record->floor_type,
        'Dinding' => $record->wall_type,
        'Atap' => $record->roof_material,
        'Air Minum' => $record->water_source,
        'Penerangan' => $record->electricity_source,
        'Daya Listrik' => $record->electricity_capacity,
        'Bahan Bakar' => $record->cooking_fuel,
        'Fasilitas BAB' => $record->toilet_facility,
        'Jenis Kloset' => $record->toilet_type,
        'Pembuangan Tinja' => $record->sewage_disposal,
        'Koordinat' => $record->latitude && $record->longitude ? $record->latitude.', '.$record->longitude : null,
    ];
    $photos = [
        'photo_front_path' => 'Tampak Depan',
        'photo_left_path' => 'Tampak Samping',
        'photo_right_path' => 'Foto Interior',
        'photo_back_path' => 'Foto Dalam',
    ];
@endphp

<div class="modal fade" id="rlthDetail{{ $record->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
        <div class="modal-header"><div><h2 class="fs-5 mb-1"><i class="fa fa-house-user me-2"></i>Detail Pendataan RTLH</h2><small class="text-secondary">{{ $record->submission_code ?: 'Data RTLH administrator' }}</small></div><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="row g-3 small">
                @foreach($detailItems as $label => $value)
                    @if(filled($value))
                        <div class="col-md-6"><div class="border rounded-3 p-2 h-100"><small class="text-secondary d-block">{{ $label }}</small><strong>{{ $value }}</strong></div></div>
                    @endif
                @endforeach
            </div>
            <hr>
            <h3 class="h6">Dokumentasi</h3>
            <div class="row g-3">
                @forelse($photos as $field => $label)
                    @if($record->{$field})
                        <div class="col-sm-6"><a href="{{ $record->photoUrl($field) }}" target="_blank" class="d-block text-decoration-none"><img src="{{ $record->photoUrl($field) }}" alt="{{ $label }}" class="img-fluid rounded border" style="width:100%;height:160px;object-fit:cover"><small class="d-block mt-1 text-secondary">{{ $label }}</small></a></div>
                    @endif
                @empty
                    <p class="text-secondary small mb-0">Belum ada dokumentasi.</p>
                @endforelse
            </div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button></div>
    </div></div>
</div>
