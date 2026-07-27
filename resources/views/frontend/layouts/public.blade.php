<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? $setting?->agency_name ?? 'Dinas PKP Maluku' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('assets/css/frontendlama.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/frontend.css') }}" rel="stylesheet">
    <style>
        :root{--pkp-navy:#183c50;--pkp-teal:#387287;--pkp-gold:#c4a465;--pkp-mist:#f4f9fb}
        body{background:var(--pkp-mist);color:#44515a}.page-breadcrumb-bar{background:linear-gradient(100deg,#163b50,#2d6f84 65%,#9bbbc3);padding:17px 0;box-shadow:0 6px 16px #18344820}.page-breadcrumb{display:flex;align-items:center;gap:12px;color:#dcecef;font-size:.93rem}.page-breadcrumb a{color:#fff;text-decoration:none;font-weight:700}.page-breadcrumb strong{color:#f7d787}.page-breadcrumb i{font-size:.7rem;color:#b9d6dd}.public-hero{position:relative;overflow:hidden;padding:72px 0;background:linear-gradient(125deg,#193b50,#2a647a 58%,#85adb9);color:#fff}.public-hero .container{position:relative;z-index:1}.content-card,.profile-dinas-container{border:1px solid #e5eef1;border-radius:20px;box-shadow:0 10px 30px #18344812;transition:.22s}.content-card:hover{transform:translateY(-4px);box-shadow:0 16px 36px #18344820}.profile-icon{width:58px;height:58px;border-radius:17px;display:grid;place-items:center;background:linear-gradient(135deg,#dceff3,#f8e7bd);color:var(--pkp-navy);font-size:24px}.content-card h2,.content-card h3{color:var(--pkp-navy);font-weight:800}.lh-lg{white-space:pre-line}.dropdown-menu{border:0;border-radius:14px;box-shadow:0 12px 32px #18344820;padding:9px}.dropdown-item{border-radius:8px;padding:9px 13px}.mega-menu{width:560px;padding:8px}.mega-menu-section{padding:15px 18px}.mega-menu-section h6{color:var(--pkp-navy);font-weight:800;border-bottom:2px solid #e5eff2;padding-bottom:9px;margin-bottom:8px}.mega-menu-section a{display:block;text-decoration:none;color:#52616a;padding:8px 4px;border-radius:7px}.mega-menu-section a:hover{background:#eaf4f6;color:var(--pkp-teal)}.mega-menu-section i{color:var(--pkp-gold);width:20px}.profile-dinas-section{margin:32px 0}.profile-dinas-container{background:#fff;padding:42px}.profile-header{text-align:center;border-bottom:2px solid #e8f0f2;padding-bottom:28px;margin-bottom:32px}.profile-title{color:var(--pkp-navy);font-weight:800;font-size:2rem}.profile-subtitle{color:var(--pkp-teal);font-weight:600}.profile-content{line-height:1.85;color:#4e5c65}.highlight-box{background:linear-gradient(135deg,#e8f5f7,#fff5dc);border-left:5px solid var(--pkp-teal);padding:24px;border-radius:12px;margin:26px 0}.timeline{position:relative;padding-left:30px}.timeline:before{content:'';position:absolute;left:5px;top:0;bottom:0;width:3px;background:linear-gradient(var(--pkp-teal),var(--pkp-gold))}.timeline-item{position:relative;margin-bottom:18px}.timeline-item:before{content:'';position:absolute;left:-31px;top:5px;width:13px;height:13px;border-radius:50%;background:var(--pkp-gold);border:3px solid #fff;box-shadow:0 0 0 3px var(--pkp-teal)}.timeline-content{background:#f3f8f9;padding:14px 17px;border-radius:10px}.main-footer{margin-top:0!important}.vm-breadcrumb,main.duty-wrap>.bg-white:first-child,main.org-wrap>.bg-white:first-child,main.official-wrap>.bg-white:first-child,nav.main-nav + .container:has(nav[aria-label="breadcrumb"]){display:none}@media(max-width:767px){.page-breadcrumb{gap:8px;font-size:.8rem;overflow-x:auto;white-space:nowrap}.public-hero{padding:52px 0}.profile-dinas-container{padding:24px}.profile-title{font-size:1.55rem}.mega-menu{width:100%}.mega-menu-section.border-start{border-left:0!important;border-top:1px solid #e5eff2}}
    </style>
</head>
<body>
@include('frontend.partials.header')
@if(($page ?? '') !== 'home')
@include('frontend.partials.breadcrumb')
@endif
@yield('content')
@include('frontend.partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
