@include('console.nav', ['title' => 'Ulasan Layanan'])

<style>
    .review-stat { position: relative; overflow: hidden; }
    .review-stat::after { content: ''; position: absolute; width: 100px; height: 100px; right: -28px; bottom: -42px; border-radius: 50%; background: #f0c76c2e; }
    .review-filter { border: 1px solid #e5eef1; border-radius: 15px; background: #f9fbfc; }
    .review-comment { max-width: 430px; color: #516d7b; font-size: .88rem; line-height: 1.55; white-space: pre-line; }
    .review-stars { letter-spacing: 1px; white-space: nowrap; }
</style>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card review-stat p-4 h-100 border-start border-4 border-warning">
            <small class="text-secondary text-uppercase fw-semibold">Rata-rata penilaian</small>
            <div class="mt-2 d-flex align-items-end gap-2">
                <strong class="display-5 text-warning lh-1">{{ number_format($average, 1) }}</strong>
                <span class="text-secondary mb-1">dari 5.0</span>
            </div>
            <span class="review-stars text-warning fs-5 mt-2">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card review-stat p-4 h-100 border-start border-4 border-primary">
            <small class="text-secondary text-uppercase fw-semibold">Total ulasan</small>
            <strong class="display-5 text-primary lh-1 mt-2">{{ $total }}</strong>
            <span class="text-secondary mt-2">Ulasan masyarakat diterima</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <small class="text-secondary text-uppercase fw-semibold d-block mb-2">Distribusi penilaian</small>
            @for($star = 5; $star >= 1; $star--)
                <div class="d-flex align-items-center gap-2 small mb-1">
                    <span class="text-warning text-nowrap fw-semibold">{{ $star }} &#9733;</span>
                    <div class="progress flex-grow-1" style="height: 7px">
                        <div class="progress-bar bg-warning" style="width: {{ $total ? (($distribution[$star] ?? 0) / $total * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-secondary" style="min-width: 18px">{{ $distribution[$star] ?? 0 }}</span>
                </div>
            @endfor
        </div>
    </div>
</div>

<form method="get" class="review-filter p-3 p-lg-4 mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-lg-4">
            <label class="form-label">Cari ulasan</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fa fa-magnifying-glass text-secondary"></i></span>
                <input type="search" name="q" class="form-control border-start-0" value="{{ request('q') }}" placeholder="Nama, komentar, atau saran">
            </div>
        </div>
        <div class="col-sm-4 col-lg-2">
            <label class="form-label">Penilaian</label>
            <select name="rating" class="form-select">
                <option value="">Semua bintang</option>
                @for($star = 5; $star >= 1; $star--)
                    <option value="{{ $star }}" @selected((string) request('rating') === (string) $star)>{{ $star }} bintang</option>
                @endfor
            </select>
        </div>
        <div class="col-sm-4 col-lg-2">
            <label class="form-label">Dari tanggal</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-sm-4 col-lg-2">
            <label class="form-label">Sampai tanggal</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-lg-2 d-flex gap-2">
            <button class="btn btn-primary flex-fill"><i class="fa fa-filter me-1"></i> Filter</button>
            <a href="/console/ulasan-layanan" class="btn btn-outline-secondary" title="Reset filter"><i class="fa fa-rotate-left"></i></a>
        </div>
    </div>
</form>

<div class="card p-3 p-lg-4">
    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
        <div>
            <h5 class="mb-1"><i class="fa fa-comments text-primary me-2"></i>Daftar Ulasan</h5>
            <small class="text-secondary">Menampilkan {{ $filteredTotal }} dari {{ $total }} ulasan layanan.</small>
        </div>
        <span class="badge rounded-pill text-bg-primary px-3 py-2">{{ $filteredTotal }} ulasan</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Pengirim</th>
                    <th>Penilaian</th>
                    <th>Komentar / Saran</th>
                    <th>Dikirim</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td><strong class="text-dark">{{ $review->name }}</strong></td>
                        <td>
                            <span class="review-stars text-warning">
                                @for($star = 1; $star <= 5; $star++)
                                    @if($star <= $review->rating)&#9733;@else&#9734;@endif
                                @endfor
                            </span>
                            <small class="text-secondary ms-1">{{ $review->rating }}/5</small>
                        </td>
                        <td><div class="review-comment">{{ $review->feedback ?: 'Tidak ada komentar atau saran.' }}</div></td>
                        <td class="text-nowrap"><small>{{ $review->created_at->translatedFormat('d M Y') }}</small><br><small class="text-secondary">{{ $review->created_at->format('H:i') }} WIT</small></td>
                        <td class="text-end">
                            <form method="post" action="/console/ulasan-layanan/{{ $review->id }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger js-swal-delete" data-message="Hapus ulasan dari {{ $review->name }}?" title="Hapus ulasan">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-secondary">
                            <i class="fa fa-comment-slash fs-3 d-block mb-2"></i>
                            Tidak ada ulasan yang sesuai dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($reviews->hasPages())
    <div class="mt-3">{{ $reviews->links() }}</div>
@endif

@include('console.end')
