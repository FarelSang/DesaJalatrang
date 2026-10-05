<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Berita Desa') — Jalatrang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/berita.css') }}">
    <style>
        .teko { font-family: 'Teko', sans-serif; }
        .topbar { background:#0f172a; color:rgba(255,255,255,.8); font-size:.78rem; padding:6px 0; border-bottom:1px solid rgba(255,255,255,.08); }
        .topbar-badge { background:linear-gradient(135deg,#f59e0b,#ef4444); color:#fff; font-weight:700; font-size:.68rem; padding:3px 8px; border-radius:12px; box-shadow:0 2px 8px rgba(245,158,11,.4); }
        .news-flash-wrapper { overflow:hidden; white-space:nowrap; flex:1; }
        .news-flash-scroll { display:inline-block; animation:scrollLeft 30s linear infinite; }
        @keyframes scrollLeft { 0% { transform:translateX(100%); } 100% { transform:translateX(-100%); } }
        .navbar-publik { position:sticky; top:0; z-index:1050; background:rgba(15,23,42,.92); backdrop-filter:blur(16px); border-bottom:1px solid rgba(255,255,255,.1); box-shadow:0 8px 32px rgba(0,0,0,.3); padding:6px 0; }
        .brand-box { background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.12); padding:4px 10px; border-radius:12px; }
        .brand-box:hover { border-color:rgba(245,158,11,.4); }
        .logo-ph { width:38px; height:38px; border-radius:50%; background:#f59e0b; color:#0f172a; display:flex; align-items:center; justify-content:center; font-weight:800; }
        .navbar-publik .nav-link { color:rgba(255,255,255,.88); font-family:'Teko',sans-serif; font-size:1.15rem; padding:4px 10px; margin:0 1px; border-radius:16px; border:1px solid transparent; white-space:nowrap; }
        .navbar-publik .nav-link:hover { color:#fbbf24; background:rgba(245,158,11,.22); border-color:rgba(245,158,11,.4); }
        .navbar-publik .nav-link.active { color:#fbbf24; background:linear-gradient(135deg,rgba(245,158,11,.25),rgba(239,68,68,.25)); border-color:rgba(245,158,11,.5); font-weight:600; }
        .nav-home-pill { background:rgba(239,68,68,.18); border-color:rgba(239,68,68,.35)!important; color:#f87171!important; }
        .navbar-publik .dropdown-menu { background:#0f172a; border:1px solid rgba(255,255,255,.18); border-radius:12px; padding:6px; min-width:200px; }
        .navbar-publik .dropdown-item { color:#f8fafc; font-size:.92rem; font-weight:500; padding:9px 16px; border-radius:8px; }
        .navbar-publik .dropdown-item:hover { background:#1e293b; color:#fbbf24; }
        @media (min-width:992px) { .navbar-publik .dropdown:hover > .dropdown-menu { display:block; } }
        .hero { background:linear-gradient(135deg,#0f3460,#1a1a6e); }
        .footer-dark { background:linear-gradient(135deg,#0f0f1a,#1a1a2e); color:rgba(255,255,255,.8); }
        .footer-dark h5 { color:#ffd700; font-size:.9rem; text-transform:uppercase; letter-spacing:.08em; }
        .footer-dark a { color:rgba(255,255,255,.65); text-decoration:none; font-size:.85rem; }
        .footer-dark a:hover { color:#ffd700; }
        .footer-bottom { background:rgba(0,0,0,.3); font-size:.8rem; color:rgba(255,255,255,.5); }
        .article-body img { width:100%; height:auto; border-radius:10px; margin:16px 0; }
        .article-body h3 { margin:1.5rem 0 .5rem; }
        .article-body p { margin-bottom:1rem; }
        .article-body ul { padding-left:1.5rem; margin-bottom:1rem; }
    </style>
    @stack('styles')
</head>
<body>

<div class="topbar">
    <div class="container-fluid px-lg-4 px-3 d-flex align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2 overflow-hidden" style="flex:1">
            <span class="topbar-badge text-nowrap"><i class="fas fa-bullhorn me-1"></i> INFO TERKINI</span>
            <div class="news-flash-wrapper"><div class="news-flash-scroll">
                @foreach ([
                    'Sekarang Anda dapat belanja langsung di Warung Desa yang merupakan Warung Online Masyarakat Desa Jalatrang.',
                    'Kini Hadir Perpustakaan Desa Selaras dengan wajah baru dan manjamen yang lebih baik',
                    'Warga bisa memeriksa langsung untuk memeriksa pembayaran PBB pada website',
                    'Desa Jalatrang akan membuka layanan public untuk mempermudah akses informasi dan pelayanan masyarakat',
                ] as $info)
                    <span class="me-5 text-white-50"><i class="far fa-circle text-warning me-1" style="font-size:.5rem"></i> {{ $info }}</span>
                @endforeach
            </div></div>
        </div>
        <div class="d-none d-md-flex text-nowrap text-white-50" style="font-size:.75rem">
            <span><i class="far fa-clock text-warning me-1"></i> {{ now()->translatedFormat('l, j F Y') }}</span>
        </div>
    </div>
</div>

@php
    $menu = [
        'Profil' => ['VISI', 'MISI', 'Sejarah', 'Struktural'],
        'Kependudukan' => null,
        'Berita' => route('berita.index'),
        'Potensi Wisata' => null,
        'IDM & SDGs' => ['IDM', 'SDGs'],
        'Ketahanan Pangan' => ['Statistik', 'Galeri', 'Top 10'],
        'Keuangan' => ['APBdes', 'PBB', 'Kegiatan'],
        'Download' => ['Regulasi', 'Materi'],
    ];
@endphp
<nav class="navbar navbar-expand-lg navbar-publik" id="mainNav">
    <div class="container-fluid px-lg-4 px-3">
        <a class="navbar-brand d-flex align-items-center gap-2 brand-box text-decoration-none me-2" href="{{ route('berita.index') }}">
            <div class="logo-ph"><img src="{{ asset('images/berita/logo.png') }}" alt="Logo Desa" style="width:38px;height:38px;object-fit:contain"></div>
            <div class="text-white">
                <div class="fw-bold teko" style="font-size:1.35rem;line-height:1">PEMERINTAH DESA JALATRANG</div>
                <div class="text-white-50 d-none d-sm-block" style="font-size:.65rem;letter-spacing:.05em">KECAMATAN CIPAKU KABUPATEN CIAMIS</div>
            </div>
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link nav-home-pill" href="{{ route('berita.index') }}"><i class="fas fa-home"></i></a></li>
                @foreach ($menu as $nama => $isi)
                    @if (is_array($isi))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ $nama }}</a>
                            <ul class="dropdown-menu">
                                @foreach ($isi as $sub)
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chevron-right me-2 text-warning" style="font-size:.65rem"></i>{{ $sub }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link {{ $nama === 'Berita' ? 'active' : '' }}" href="{{ $isi ?? '#' }}">{{ $nama }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</nav>

@if (session('success'))
    <div class="container mt-3">
        <div class="alert alert-success mb-0">
            {{ session('success') }}
        </div>
    </div>
@endif

@yield('hero')

<main class="container py-5">
    @yield('content')
</main>

<footer class="footer-dark pt-5 pb-2 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="logo-ph"><img src="{{ asset('images/berita/logo.png') }}" alt="Logo Desa" style="width:38px;height:38px;object-fit:contain"></div>
                    <div>
                        <div class="fw-bold text-white">PEMERINTAH DESA</div>
                        <div class="fw-bold text-warning" style="font-size:1.1rem">JALATRANG</div>
                    </div>
                </div>
                <p style="font-size:.83rem;line-height:1.7">
                    Jalan Raya Cipaku Nomor 181<br>Desa Jalatrang, Kecamatan Cipaku<br>Kabupaten Ciamis<br>
                    <i class="fas fa-phone me-1"></i> 08<br>
                    <i class="fas fa-envelope me-1"></i> pemerintahdesajalatrang@gmail.com
                </p>
                <a href="https://www.google.com/maps/place/Jalatrang" target="_blank" class="btn btn-sm btn-outline-warning mt-1"><i class="fas fa-map-marker-alt me-1"></i> Lihat Peta</a>
            </div>
            <div class="col-lg-2 col-6">
                <h5 class="mb-3">Menu</h5>
                <ul class="list-unstyled">
                    @foreach (['Beranda', 'Berita', 'Struktural', 'APBDes', 'Prestasi'] as $m)
                        <li class="mb-1"><a href="{{ $m === 'Berita' ? route('berita.index') : '#' }}"><i class="bi bi-chevron-right me-1"></i>{{ $m }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-6">
                <h5 class="mb-3">Link Terkait</h5>
                <ul class="list-unstyled">
                    <li class="mb-1"><a href="https://kemendesa.go.id" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i>Kemendesa</a></li>
                    <li class="mb-1"><a href="https://ciamis.go.id" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i>Kab. Ciamis</a></li>
                    <li class="mb-1"><a href="https://jabar.go.id" target="_blank"><i class="bi bi-box-arrow-up-right me-1"></i>Pemprov Jabar</a></li>
                    <li class="mb-1"><a href="#"><i class="bi bi-shield-lock me-1"></i>Panel Admin</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5 class="mb-3">Media Sosial</h5>
                <a href="https://x.com" target="_blank" class="d-block mb-2"><i class="fab fa-x-twitter me-2"></i>twitter/x</a>
                <a href="https://facebook.com" target="_blank" class="d-block mb-2"><i class="fab fa-facebook me-2"></i>facebook</a>
                <a href="https://www.youtube.com/@jalatrangTV" target="_blank" class="d-block mb-2"><i class="fab fa-youtube me-2"></i>youtube</a>
                <a href="https://instagram.com/pemerintahdesajalatrang" target="_blank" class="d-block mb-2"><i class="fab fa-instagram me-2"></i>instagram</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center mt-4 py-3">&copy; {{ date('Y') }} Pemerintah Desa Jalatrang — Semua hak dilindungi.</div>
</footer>

<button type="button" class="btn-top" id="btnTop" aria-label="Ke atas"><i class="fas fa-chevron-up"></i></button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const btnTop = document.getElementById('btnTop');
    window.addEventListener('scroll', () => btnTop.classList.toggle('show', window.scrollY > 300));
    btnTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
</script>
@stack('scripts')
</body>
</html>
