@extends('layouts.app')

@section('title', 'Berita & Informasi')

@section('hero')
<section class="page-hero">
    <div class="container">
        <div class="crumbs">
            <a href="{{ route('berita.index') }}">Beranda</a>
            <span>Berita</span>
        </div>
        <h1>Berita &amp; Informasi</h1>
        <p>Informasi terkini dari Desa Jalatrang</p>
    </div>
</section>
@endsection

@section('content')
<div class="row">

    {{-- Sidebar filter --}}
    <div class="col-lg-3 mb-4">
      <div class="sticky-side">
        <div class="filter-box">
            <div class="filter-header"><i class="fas fa-filter me-2"></i>Filter Berita</div>
            <div class="filter-body">
                <form method="GET" action="{{ route('berita.index') }}">
                    <label class="form-label fw-semibold">Kata Kunci</label>
                    <input type="text" name="kata_kunci" class="form-control mb-3"
                           value="{{ request('kata_kunci') }}" placeholder="Cari berita...">

                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="kategori" class="form-select mb-3">
                        <option value="">Semua Kategori</option>
                        @foreach (['Olahraga', 'Pendidikan', 'Potensi', 'Pembangunan'] as $k)
                            <option value="{{ $k }}" @selected(request('kategori') == $k)>{{ $k }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary w-100 mb-2">Cari</button>
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </form>
            </div>
        </div>

        <a href="{{ route('berita.create') }}" class="btn btn-success w-100 mt-3">+ Tambah Berita</a>
      </div>
    </div>

    {{-- Daftar berita --}}
    <div class="col-lg-9">
        <div class="row">
            @forelse ($beritas as $berita)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card card-berita h-100">
                        <img src="{{ $berita->gambar_url }}" class="card-img-top" alt="{{ $berita->judul }}">

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge badge-kategori">{{ $berita->kategori }}</span>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i> {{ $berita->tanggal->translatedFormat('d M Y') }}
                                </small>
                            </div>

                            <h6>
                                <a href="{{ route('berita.show', $berita) }}" class="text-decoration-none fw-bold">
                                    {{ \Illuminate\Support\Str::limit($berita->judul, 75) }}
                                </a>
                            </h6>

                            <p class="excerpt">{{ $berita->excerpt }}</p>

                            <div class="card-tags mb-2">
                                @foreach (array_slice($berita->tags, 0, 3) as $tag)
                                    <span class="tag-pill">#{{ $tag }}</span>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                                <span class="views"><i class="fas fa-eye me-1"></i>{{ $berita->views }}</span>
                                <a href="{{ route('berita.show', $berita) }}" class="btn btn-sm btn-baca">
                                    Baca <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                            {{-- Aksi admin --}}
                            <div class="mt-3 pt-2 border-top d-flex gap-2">
                                <a href="{{ route('berita.edit', $berita) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form action="{{ route('berita.destroy', $berita) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Berita tidak ditemukan.</p>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $beritas->links() }}
        </div>
    </div>
</div>
@endsection
