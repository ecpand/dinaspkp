@php
    $isProfilePage = in_array($page ?? '', ['profil-dinas','visi-misi','tugas-pokok-fungsi','struktur-organisasi','profil-pejabat']);
    $label = $title ?? ucwords(str_replace('-', ' ', $page ?? ''));
@endphp
<section class="page-breadcrumb-bar" aria-label="Breadcrumb"><div class="container"><nav class="page-breadcrumb"><a href="/"><i class="fas fa-house me-2"></i>Beranda</a>@if($isProfilePage)<i class="fas fa-chevron-right"></i><span>Profil</span>@endif<i class="fas fa-chevron-right"></i><strong>{{ $label }}</strong></nav></div></section>
