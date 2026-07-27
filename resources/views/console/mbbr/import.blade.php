@include('console.nav',['title'=>'Import Penerima MBBR'])
<div class="card p-4">
    <h2 class="h5">Import Data Penerima</h2>
    <p class="text-secondary">Unggah CSV dengan format kolom impor MBBR: Tahun Anggaran, Nama Penerima Bantuan, Kabupaten/Kota, Nama Desa, Jenis Program, Sub Program, dan Status.</p>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form method="post" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-8"><input type="file" name="file" accept=".csv,.txt" class="form-control" required></div>
        <div class="col-md-4"><button class="btn btn-primary">Import CSV</button></div>
    </form>
</div>
@include('console.end')
