@extends('frontend.layouts.public')

@section('content')
<main class="sigaprumabeta-page py-5">
    <div class="container">
        <section class="sigaprumabeta-hero">
            <div class="sigaprumabeta-icon"><i class="fas {{ $sigaprumabeta['icon'] }}"></i></div>
            <div><span>SIGAPRUMABETA</span><h1>{{ $sigaprumabeta['title'] }}</h1><p>{{ $sigaprumabeta['description'] }}</p></div>
        </section>
        <section class="sigaprumabeta-card mt-4">
            <div class="sigaprumabeta-card-icon"><i class="fas fa-database"></i></div>
            <div><h2>Data sedang dipersiapkan</h2><p>Halaman {{ $sigaprumabeta['title'] }} telah tersedia sebagai bagian dari SIGAPRumaBeta. Data akan ditampilkan setelah proses pendataan dan verifikasi oleh Dinas PKP Maluku selesai.</p></div>
        </section>
    </div>
</main>
<style>.sigaprumabeta-page{min-height:58vh;background:linear-gradient(145deg,#edf7fb,#fffaf0)}.sigaprumabeta-hero{display:flex;align-items:center;gap:23px;padding:42px;border-radius:22px;background:linear-gradient(120deg,#163d51,#28788a);box-shadow:0 18px 40px #173e5424;color:#fff}.sigaprumabeta-icon,.sigaprumabeta-card-icon{display:grid;flex:0 0 76px;width:76px;height:76px;place-items:center;border-radius:20px;background:#ffffff1c;color:#f2cf87;font-size:2rem}.sigaprumabeta-hero span{color:#f2cf87;font-size:.75rem;font-weight:900;letter-spacing:.14em}.sigaprumabeta-hero h1{margin:6px 0 9px;font-size:2rem;font-weight:900}.sigaprumabeta-hero p{max-width:720px;margin:0;color:#d9ecf1;line-height:1.7}.sigaprumabeta-card{display:flex;gap:19px;align-items:flex-start;padding:30px;border:1px solid #e0eaed;border-radius:18px;background:#fff;box-shadow:0 10px 27px #173e5412}.sigaprumabeta-card-icon{width:58px;height:58px;flex-basis:58px;border-radius:15px;background:#edf5f6;color:#24758a;font-size:1.35rem}.sigaprumabeta-card h2{margin:2px 0 8px;color:#254957;font-size:1.2rem;font-weight:900}.sigaprumabeta-card p{max-width:780px;margin:0;color:#6b7e86;line-height:1.7}@media(max-width:576px){.sigaprumabeta-hero{align-items:flex-start;padding:29px;flex-direction:column}.sigaprumabeta-card{padding:23px}}</style>
@endsection
