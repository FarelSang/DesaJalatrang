@extends('layouts.app')

@section('title', $berita->judul)

@section('hero')
<section class="page-hero slim">
    <div class="container">
        <div class="crumbs">
            <a href="{{ route('berita.index') }}">Beranda</a>
            <a href="{{ route('berita.index') }}">Berita</a>
            <span>Detail</span>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="row g-4">

    {{-- Artikel --}}
    <div class="col-lg-8">
        <article class="article-card">
            @if ($berita->gambar)
                <img src="{{ $berita->gambar_url }}" class="cover" alt="{{ $berita->judul }}">
            @endif

            <div class="article-inner">
                <div class="article-meta">
                    <span class="badge badge-kategori">{{ $berita->kategori }}</span>
                    <span><i class="fas fa-calendar-alt me-1"></i>{{ $berita->tanggal->translatedFormat('l, d F Y') }}</span>
                    <span><i class="fas fa-user me-1"></i>{{ $berita->penulis }}</span>
                    <span><i class="fas fa-eye me-1"></i>{{ $berita->views }} dibaca</span>
                </div>

                <h1 class="article-title">{{ $berita->judul }}</h1>

                <div class="berita-content">{!! $berita->isi !!}</div>

                <div class="article-author">Team_Media; {{ $berita->penulis }}</div>

                <div class="tags-row">
                    <span class="label"><i class="fas fa-tags me-1"></i>Tags:</span>
                    @foreach ($berita->tags as $tag)
                        <span class="tag-pill">#{{ $tag }}</span>
                    @endforeach
                </div>

                <div class="share-row">
                    <strong>Bagikan:</strong>
                    <a class="btn-share fb" target="_blank" rel="noopener"
                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="fab fa-facebook-f me-1"></i>Facebook</a>
                    <a class="btn-share tw" target="_blank" rel="noopener"
                       href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}"><i class="fab fa-twitter me-1"></i>Twitter</a>
                    <a class="btn-share wa" target="_blank" rel="noopener"
                       href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}"><i class="fab fa-whatsapp me-1"></i>WhatsApp</a>
                </div>
            </div>
        </article>

        {{-- Komentar --}}
        <section class="comment-card" id="komentar">
            <h3><i class="fas fa-comments"></i>Komentar ({{ $komentars->count() }})</h3>

            @if (session('komentar_ok'))
                <div class="alert alert-success py-2">{{ session('komentar_ok') }}</div>
            @endif

            <form class="comment-form" method="POST" action="{{ route('komentar.store', $berita) }}">
                @csrf
                <div class="fw-semibold mb-3"><i class="far fa-edit me-1"></i> Tulis Komentar Anda:</div>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Anda">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Alamat Email <span class="text-danger">*</span> <span class="badge-privat">Privat</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label>Nomor HP <span class="text-danger">*</span> <span class="badge-privat">Privat</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control @error('no_hp') is-invalid @enderror" placeholder="08xxxxxxxxxx">
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <label>Pesan Komentar <span class="text-danger">*</span></label>
                <textarea name="pesan" id="pesan" rows="3" maxlength="300" class="form-control @error('pesan') is-invalid @enderror" placeholder="Tuliskan masukan atau komentar Anda...">{{ old('pesan') }}</textarea>
                @error('pesan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <div class="d-flex justify-content-between small text-muted mt-1 mb-3">
                    <span>Dilarang menggunakan kata kasar / ujaran kebencian.</span>
                    <span><span id="sisa">{{ 300 - strlen(old('pesan', '')) }}</span> karakter tersisa</span>
                </div>

                <div class="captcha-box mb-3">
                    <div class="fw-semibold small mb-2"><i class="fas fa-shield-alt text-primary me-1"></i> Pertanyaan Keamanan (Captcha Anti-Bot) <span class="text-danger">*</span></div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="captcha-q" id="captchaQ">{{ $soal }}</span>
                        <input type="text" name="captcha" id="captchaA" class="form-control @error('captcha') is-invalid @enderror" style="max-width:130px" placeholder="Jawaban" autocomplete="off">
                        <button type="button" class="btn btn-outline-secondary" id="captchaRefresh" title="Ganti soal"><i class="fas fa-sync-alt"></i></button>
                    </div>
                    @error('captcha') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-kirim"><i class="fas fa-paper-plane me-1"></i> Kirim Komentar</button>
            </form>

            @forelse ($komentars as $k)
                <div class="komentar-item">
                    <div class="avatar">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($k->nama, 0, 1)) }}</div>
                    <div>
                        <div class="fw-semibold">{{ $k->nama }} <small class="text-muted fw-normal ms-1">{{ $k->created_at->diffForHumans() }}</small></div>
                        <div class="komentar-pesan">{{ $k->pesan }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-comment">
                    <i class="far fa-comments"></i>
                    Belum ada komentar. Jadilah yang pertama memberikan masukan!
                </div>
            @endforelse
        </section>

        <a href="{{ route('berita.index') }}" class="btn-kembali"><i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar</a>
    </div>

    {{-- Sidebar Berita Terkait --}}
    <div class="col-lg-4">
        <div class="side-box sticky-side">
            <div class="filter-header"><i class="far fa-newspaper"></i> Berita Terkait</div>
            <div class="px-3">
                @foreach ($terkait as $item)
                    <a href="{{ route('berita.show', $item) }}" class="related-item">
                        <img src="{{ $item->gambar_url }}" alt="">
                        <div>
                            <div class="t">{{ \Illuminate\Support\Str::limit($item->judul, 62) }}</div>
                            <div class="d"><i class="fas fa-calendar-alt me-1"></i>{{ $item->tanggal->translatedFormat('j M Y') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('captchaRefresh').addEventListener('click', async () => {
        const r = await fetch('{{ route('captcha') }}', { headers: { 'Accept': 'application/json' } });
        document.getElementById('captchaQ').textContent = (await r.json()).soal;
        document.getElementById('captchaA').value = '';
    });
    document.getElementById('pesan').addEventListener('input', e => {
        document.getElementById('sisa').textContent = 300 - e.target.value.length;
    });
</script>
@endpush
